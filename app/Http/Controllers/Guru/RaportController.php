<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AspekPerkembangan;
use App\Models\Penilaian;
use App\Models\DeskripsiAspek;
use App\Models\Presensi;
use App\Models\Antropometri;
use App\Models\RefleksiGuru;
use App\Models\PengaturanSekolah;
use App\Models\KatagoriKegiatan;
use App\Models\NilaiKegiatan;
use Barryvdh\DomPDF\Facade\Pdf;

class RaportController extends Controller
{
    // ==================================================
    // DAFTAR SISWA
    // ==================================================

    public function index()
    {
        $kelasSaya = Kelas::where('id_user', auth()->id())->get();

        if ($kelasSaya->isEmpty()) {
            return back()->with('error', 'Anda belum memiliki kelas.');
        }

        $kelasId = request('id_kelas') ?? $kelasSaya->first()->id_kelas;

        $siswa = Siswa::where('id_kelas', $kelasId)
            ->orderBy('nama_siswa')
            ->get();

        foreach ($siswa as $item) {

            $item->statusRaport = count(
                $this->validasiRaport($item->id_siswa)
            ) == 0;

        }

        return view(
            'guru.raport.index',
            compact(
                'kelasSaya',
                'kelasId',
                'siswa'
            )
        );
    }

    // ==================================================
    // PREVIEW RAPORT
    // ==================================================

    public function show($id)
    {
        $kurang = $this->validasiRaport($id);

        if (count($kurang) > 0) {

            return redirect()
                ->route('guru.raport.index')
                ->with(
                    'error',
                    implode("\n", $kurang)
                );

        }

        $data = $this->getData($id);

        return view('guru.raport.show', $data);
    }

    // ==================================================
    // CETAK PDF
    // ==================================================
public function pdf($id)
{
    $kurang = $this->validasiRaport($id);

    if (count($kurang) > 0) {
        return redirect()
            ->route('guru.raport.index')
            ->with('error', implode("\n", $kurang));
    }

    $data = $this->getData($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('guru.raport.pdf', $data);

    $pdf->setPaper('f4', 'portrait');

    return $pdf->stream(
        'Raport_' . str_replace(' ', '_', $data['siswa']->nama_siswa) . '_S' . $data['semester'] . '.pdf'
    );
}

    // ==================================================
    // AMBIL SEMUA DATA RAPORT
    // ==================================================

    private function getData($id)
    {
                // ==========================
        // SEMESTER & TAHUN AJARAN
        // ==========================

        $semester = 1;

        $tahun_ajaran = date('Y') . '/' . (date('Y') + 1);

        // ==========================
        // DATA SISWA
        // ==========================

        $siswa = Siswa::with('kelas')->findOrFail($id);

        // ==========================
        // PROFIL SEKOLAH
        // ==========================

        $pengaturan = PengaturanSekolah::first();

        // ==========================
        // ASPEK PERKEMBANGAN
        // ==========================

        $aspek = AspekPerkembangan::with([
            'indikatorPenilaian' => function ($q) {
                $q->orderBy('urutan');
            }
        ])
        ->orderBy('urutan')
        ->get();

        // ==========================
        // PENILAIAN
        // ==========================

        $penilaian = Penilaian::where('id_siswa', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->groupBy('id_indikator');

        // ==========================
        // DESKRIPSI
        // ==========================

        $deskripsi = DeskripsiAspek::where('id_siswa', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->keyBy('id_aspek');

        // ==========================
        // KEGIATAN TAMBAHAN
        // ==========================

        $katagori = KatagoriKegiatan::with([
            'itemKegiatan' => function ($q) {
                $q->orderBy('urutan');
            }
        ])
        ->orderBy('urutan')
        ->get();

        $kegiatan = NilaiKegiatan::where('id_siswa', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get();

        // ==========================
        // PRESENSI
        // ==========================

        $presensi = Presensi::where('id_siswa', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        // ==========================
        // ANTROPOMETRI
        // ==========================

        $antropometri = Antropometri::where('id_siswa', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        // ==========================
        // REFLEKSI GURU
        // ==========================

        $refleksiGuru = RefleksiGuru::where('id_siswa', $id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();

        // ==========================
        // KIRIM KE VIEW
        // ==========================

        return compact(
            'siswa',
            'semester',
            'tahun_ajaran',
            'pengaturan',
            'aspek',
            'penilaian',
            'deskripsi',
            'katagori',
            'kegiatan',
            'presensi',
            'antropometri',
            'refleksiGuru'
        );
    }
        // ==================================================
    // VALIDASI KELENGKAPAN RAPORT
    // ==================================================

    private function validasiRaport($id)
    {
        $semester = 1;

        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);

        $pesan = [];

        // ==========================
        // PENILAIAN
        // ==========================

        if (
            Penilaian::where('id_siswa', $id)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->count() == 0
        ) {

            $pesan[] = "Penilaian belum diinput.";

        }

        // ==========================
        // DESKRIPSI PER ASPEK
        // ==========================

        $aspek = AspekPerkembangan::all();

        foreach ($aspek as $item) {

            $desk = DeskripsiAspek::where('id_siswa', $id)
                ->where('id_aspek', $item->id_aspek)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->first();

            if (!$desk) {

                $pesan[] = "Deskripsi aspek '{$item->nama_aspek}' belum diisi.";

                continue;
            }

            if (trim($desk->deskripsi) == '') {

                $pesan[] = "Deskripsi aspek '{$item->nama_aspek}' masih kosong.";

            }

            // FOTO TIDAK WAJIB
            // Jika nanti sekolah mewajibkan foto,
            // tinggal buka komentar di bawah.

            /*
            if (
                empty($desk->foto1) &&
                empty($desk->foto2) &&
                empty($desk->foto3)
            ) {

                $pesan[] = "Foto kegiatan aspek '{$item->nama_aspek}' belum diupload.";

            }
            */

        }

        // ==========================
        // KEGIATAN TAMBAHAN
        // ==========================

        if (
            NilaiKegiatan::where('id_siswa', $id)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->count() == 0
        ) {

            $pesan[] = "Kegiatan tambahan belum diinput.";

        }

        // ==========================
        // PRESENSI
        // ==========================

        if (
            !Presensi::where('id_siswa', $id)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->exists()
        ) {

            $pesan[] = "Presensi belum diinput.";

        }

        // ==========================
        // ANTROPOMETRI
        // ==========================

        if (
            !Antropometri::where('id_siswa', $id)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->exists()
        ) {

            $pesan[] = "Antropometri belum diinput.";

        }

        // ==========================
        // REFLEKSI GURU
        // ==========================

        if (
            !RefleksiGuru::where('id_siswa', $id)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->exists()
        ) {

            $pesan[] = "Refleksi guru belum diisi.";

        }

        return $pesan;
    }
}