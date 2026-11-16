<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AspekPerkembangan;
use App\Models\Penilaian;
use App\Models\DeskripsiAspek;
use App\Models\Presensi;
use App\Models\PresensiRaport;
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
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        $semuaAkses  = $kelasDiampu->isEmpty();

        $kelasSaya = $semuaAkses
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        $defaultKelasId = $semuaAkses
            ? 'semua'
            : ($kelasSaya->first()?->id_kelas ?? 'semua');

        $kelasId  = request('id_kelas') ?? $defaultKelasId;
        $semester = request('semester') ?? 1;

        $query = Siswa::with('kelas')->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $siswa = $query->get();

        foreach ($siswa as $item) {
            $item->statusRaport = count(
                $this->validasiRaport($item->id_siswa, $semester)
            ) == 0;
        }

        return view(
            'guru.raport.index',
            compact(
                'kelasSaya',
                'kelasId',
                'semuaAkses',
                'semester',
                'siswa'
            )
        );
    }

    // ==================================================
    // PREVIEW RAPORT
    // ==================================================

    public function show($id)
    {
        $semester = request('semester') ?? 1;
        $kurang = $this->validasiRaport($id, $semester);

        if (count($kurang) > 0) {
            return redirect()
                ->route('guru.raport.index')
                ->with(
                    'error',
                    implode("\n", $kurang)
                );
        }

        $data = $this->getData($id, $semester);

        return view('guru.raport.show', $data);
    }

    // ==================================================
    // CETAK PDF
    // ==================================================

    public function pdf($id)
    {
        $semester = request('semester') ?? 1;
        $kurang = $this->validasiRaport($id, $semester);

        if (count($kurang) > 0) {
            return redirect()
                ->route('guru.raport.index')
                ->with('error', implode("\n", $kurang));
        }

        $data = $this->getData($id, $semester);

        $pdf = Pdf::loadView('guru.raport.pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Raport_' . str_replace(' ', '_', $data['siswa']->nama_siswa) . '_S' . $data['semester'] . '.pdf'
        );
    }

    // ==================================================
    // CETAK SEMUA RAPORT SATU KELAS
    // ==================================================

    public function cetakSemua()
    {
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        $semuaAkses  = $kelasDiampu->isEmpty();

        $kelasSaya = $semuaAkses
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        $defaultKelasId = $semuaAkses
            ? 'semua'
            : ($kelasSaya->first()?->id_kelas ?? 'semua');

        $kelasId  = request('id_kelas') ?? $defaultKelasId;
        $semester = request('semester') ?? 1;

        $query = Siswa::with('kelas')->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $daftarSiswa = $query->get();

        $semuaData = [];
        foreach ($daftarSiswa as $s) {
            if (count($this->validasiRaport($s->id_siswa, $semester)) === 0) {
                $semuaData[] = $this->getData($s->id_siswa, $semester);
            }
        }

        if (empty($semuaData)) {
            return back()->with('error', 'Belum ada siswa dengan data raport yang lengkap.');
        }

        $pdf = Pdf::loadView('guru.raport.pdf_semua', compact('semuaData'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Raport_Semua_Siswa_S' . $semester . '.pdf');
    }

    // ==================================================
    // AMBIL SEMUA DATA RAPORT
    // ==================================================

    private function getData($id, $semester = 1)
    {
        $siswa = Siswa::with('kelas.user')->findOrFail($id);

        $tahun_ajaran = $siswa->kelas->tahun_ajaran ?? (date('Y') . '/' . (date('Y') + 1));

        $pengaturan = PengaturanSekolah::first() ?? new PengaturanSekolah([
            'nama_sekolah'   => 'TK AL-IKHLAS TALIWANG',
            'alamat'         => 'Taliwang',
            'kepala_sekolah' => 'Putri Balqis, S.E',
            'nip_kepala'     => '-',
        ]);

        $aspek = AspekPerkembangan::with([
            'indikatorPenilaian' => function ($q) {
                $q->orderBy('urutan');
            }
        ])
        ->orderBy('urutan')
        ->get();

        $penilaian = Penilaian::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderByDesc('updated_at')
            ->get()
            ->groupBy('id_indikator');

        $deskripsi = DeskripsiAspek::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderBy('updated_at')
            ->get()
            ->keyBy('id_aspek');

        $katagori = KatagoriKegiatan::with([
            'itemKegiatan' => function ($q) {
                $q->orderBy('urutan');
            }
        ])
        ->orderBy('urutan')
        ->get();

        $kegiatan = NilaiKegiatan::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderByDesc('updated_at')
            ->get();

        $presensiHarian = Presensi::where('id_siswa', $id)
            ->where('semester', $semester)
            ->get();

        $presensiRekap = PresensiRaport::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderByDesc('updated_at')
            ->first();

        $sakitCount = $presensiHarian->where('status', 'sakit')->count();
        $izinCount  = $presensiHarian->where('status', 'izin')->count() ?: ($presensiRekap->izin ?? 0);
        $alphaCount = $presensiHarian->where('status', 'tanpa_keterangan')->count() ?: ($presensiRekap->tanpa_keterangan ?? 0);
        $hadirCount = $presensiHarian->where('status', 'hadir')->count() ?: ($presensiRekap->hadir ?? 0);

        $presensi = (object) [
            'hadir'            => $hadirCount,
            'sakit'            => $sakitCount,
            'izin'             => $izinCount,
            'alpha'            => $alphaCount,
            'tanpa_keterangan' => $alphaCount,
        ];

        $antropometri = Antropometri::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderByDesc('updated_at')
            ->first();

        $refleksiGuru = RefleksiGuru::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderByDesc('updated_at')
            ->first();

        if ($refleksiGuru && empty($refleksiGuru->refleksi)) {
            $refleksiGuru->refleksi = $refleksiGuru->catatan_guru;
        }

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

    private function validasiRaport($id, $semester = 1)
    {
        $pesan = [];

        if (
            Penilaian::where('id_siswa', $id)
                ->where('semester', $semester)
                ->count() == 0
        ) {
            $pesan[] = "Penilaian belum diinput.";
        }

        $aspek = AspekPerkembangan::all();

        foreach ($aspek as $item) {
            $desk = DeskripsiAspek::where('id_siswa', $id)
                ->where('id_aspek', $item->id_aspek)
                ->where('semester', $semester)
                ->orderByDesc('updated_at')
                ->first();

            if (!$desk) {
                $pesan[] = "Deskripsi aspek '{$item->nama_aspek}' belum diisi.";
                continue;
            }

            if (trim((string) $desk->deskripsi) == '') {
                $pesan[] = "Deskripsi aspek '{$item->nama_aspek}' masih kosong.";
            }
        }

        if (
            NilaiKegiatan::where('id_siswa', $id)
                ->where('semester', $semester)
                ->count() == 0
        ) {
            $pesan[] = "Kegiatan tambahan belum diinput.";
        }

        $adaPresensi = Presensi::where('id_siswa', $id)
            ->where('semester', $semester)
            ->exists()
            || PresensiRaport::where('id_siswa', $id)
                ->where('semester', $semester)
                ->exists();

        if (!$adaPresensi) {
            $pesan[] = "Presensi belum diinput.";
        }

        if (
            !Antropometri::where('id_siswa', $id)
                ->where('semester', $semester)
                ->exists()
        ) {
            $pesan[] = "Antropometri belum diinput.";
        }

        $refleksi = RefleksiGuru::where('id_siswa', $id)
            ->where('semester', $semester)
            ->orderByDesc('updated_at')
            ->first();

        if (!$refleksi || trim((string) $refleksi->catatan_guru) === '') {
            $pesan[] = "Refleksi guru belum diisi.";
        }

        return $pesan;
    }
}
