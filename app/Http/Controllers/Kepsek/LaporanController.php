<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\AspekPerkembangan;
use App\Models\Kelas;
use App\Models\Penilaian;
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
     * Laporan presensi seluruh siswa
     */
    public function presensi(Request $request)
    {
        $semester = $request->semester ?? 1;
        $tahunAjaran = $request->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1);
        $kelasId = $request->id_kelas;

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $query = Siswa::with('kelas')->orderBy('nama_siswa');

        if (!empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        }

        $siswa = $query->get();

        $rekapPresensi = PresensiRaport::whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        return view('kepsek.laporan.presensi', compact(
            'kelasList',
            'kelasId',
            'semester',
            'tahunAjaran',
            'siswa',
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