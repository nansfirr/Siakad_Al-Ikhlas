<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\AspekPerkembangan;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\Presensi;
use App\Models\PresensiRaport;
use App\Models\Siswa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan perkembangan seluruh siswa
     */
    public function perkembangan(Request $request)
    {
        $semester = $request->semester ?? 1;
        $tahunAjaran = $request->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1);
        $kelasId = $request->id_kelas;

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $aspek = AspekPerkembangan::orderBy('urutan')->get();

        $query = Siswa::with('kelas')->orderBy('nama_siswa');

        if (!empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        }

        $siswa = $query->get();

        $rekapNilai = [];

        foreach ($siswa as $itemSiswa) {
            foreach ($aspek as $itemAspek) {
                $nilai = Penilaian::where('id_siswa', $itemSiswa->id_siswa)
                    ->where('semester', $semester)
                    ->whereHas('indikator', function ($q) use ($itemAspek) {
                        $q->where('id_aspek', $itemAspek->id_aspek);
                    })
                    ->pluck('nilai')
                    ->toArray();

                $rekapNilai[$itemSiswa->id_siswa][$itemAspek->id_aspek] = $this->getModus($nilai);
            }
        }

        return view('kepsek.laporan.perkembangan', compact(
            'kelasList',
            'kelasId',
            'semester',
            'tahunAjaran',
            'siswa',
            'aspek',
            'rekapNilai'
        ));
    }

    /**
     * Laporan presensi seluruh siswa (Harian & Rekap Total Semester)
     */
    public function presensi(Request $request)
    {
        $semester = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1);
        $kelasId = $request->id_kelas;

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $query = Siswa::with('kelas')->orderBy('nama_siswa');

        if (!empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        }

        $siswa = $query->get();
        $siswaIds = $siswa->pluck('id_siswa');

        // Daftar tanggal yang sudah memiliki presensi pada semester & tahun ajaran ini
        $tanggalTersedia = Presensi::whereIn('id_siswa', $siswaIds)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->select('tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->limit(15)
            ->pluck('tanggal');

        // Default tanggal: dari request, atau tanggal presensi terbaru jika hari ini belum ada, atau hari ini
        $tanggal = $request->tanggal
            ?? ($tanggalTersedia->contains(date('Y-m-d')) ? date('Y-m-d') : ($tanggalTersedia->first() ?? date('Y-m-d')));

        // Data presensi harian pada tanggal terpilih
        $presensiHarian = Presensi::whereIn('id_siswa', $siswaIds)
            ->where('tanggal', $tanggal)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        // Ringkasan jumlah status pada tanggal terpilih
        $ringkasanHarian = [
            'hadir'            => $presensiHarian->where('status', 'hadir')->count(),
            'sakit'            => $presensiHarian->where('status', 'sakit')->count(),
            'izin'             => $presensiHarian->where('status', 'izin')->count(),
            'tanpa_keterangan' => $presensiHarian->where('status', 'tanpa_keterangan')->count(),
        ];
        $ringkasanHarian['belum_diinput'] = max(0, $siswa->count() - $presensiHarian->count());

        // Rekap total presensi per siswa selama 1 semester (gabungan tabel presensi harian + presensi_raport)
        $semuaPresensiSemester = Presensi::whereIn('id_siswa', $siswaIds)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->groupBy('id_siswa');

        $rekapTabel = PresensiRaport::whereIn('id_siswa', $siswaIds)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        $rekapPresensi = [];
        foreach ($siswa as $s) {
            $harianSiswa = $semuaPresensiSemester->get($s->id_siswa, collect());
            $rekapRow = $rekapTabel->get($s->id_siswa);

            if ($harianSiswa->isNotEmpty()) {
                $rekapPresensi[$s->id_siswa] = (object) [
                    'hadir'            => $harianSiswa->where('status', 'hadir')->count(),
                    'sakit'            => $harianSiswa->where('status', 'sakit')->count(),
                    'izin'             => $harianSiswa->where('status', 'izin')->count(),
                    'tanpa_keterangan' => $harianSiswa->where('status', 'tanpa_keterangan')->count(),
                ];
            } elseif ($rekapRow) {
                $rekapPresensi[$s->id_siswa] = (object) [
                    'hadir'            => $rekapRow->hadir ?? 0,
                    'sakit'            => $rekapRow->sakit ?? 0,
                    'izin'             => $rekapRow->izin ?? 0,
                    'tanpa_keterangan' => $rekapRow->tanpa_keterangan ?? 0,
                ];
            } else {
                $rekapPresensi[$s->id_siswa] = (object) [
                    'hadir'            => 0,
                    'sakit'            => 0,
                    'izin'             => 0,
                    'tanpa_keterangan' => 0,
                ];
            }
        }

        return view('kepsek.laporan.presensi', compact(
            'kelasList',
            'kelasId',
            'semester',
            'tahunAjaran',
            'tanggal',
            'tanggalTersedia',
            'siswa',
            'presensiHarian',
            'ringkasanHarian',
            'rekapPresensi'
        ));
    }

    /**
     * Mengambil nilai yang paling sering muncul (modus)
     */
    private function getModus(array $nilai): string
    {
        if (empty($nilai)) {
            return '-';
        }

        $jumlah = array_count_values($nilai);
        arsort($jumlah);

        return array_key_first($jumlah);
    }
}
