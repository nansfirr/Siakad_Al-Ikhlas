<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\NilaiKegiatan;
use App\Models\PresensiRaport;
use App\Models\AspekPerkembangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelasSaya   = Kelas::where('id_user', auth()->id())->get();
        $kelasId     = $request->id_kelas ?? $kelasSaya->first()?->id_kelas;
        $semester    = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y').'/'.((int)date('Y')+1);

        $kelas  = Kelas::find($kelasId);
        $siswa  = Siswa::where('id_kelas', $kelasId)->orderBy('nama_siswa')->get();
        $aspek  = AspekPerkembangan::orderBy('urutan')->get();

        // Rekap nilai per siswa per aspek
        $rekapNilai = [];
        foreach ($siswa as $s) {
            foreach ($aspek as $a) {
                $nilaiList = Penilaian::where('id_siswa', $s->id_siswa)
                    ->where('semester', $semester)
                    ->whereHas('indikator', function ($q) use ($a) {
                         $q->where('id_aspek', $a->id_aspek);
                         })
                    ->pluck('nilai');

                // Hitung nilai terbanyak (modus) per aspek
                $rekapNilai[$s->id_siswa][$a->id_aspek] = $this->getModus($nilaiList->toArray());
            }
        }

        // Rekap presensi
        $rekapPresensi = PresensiRaport::whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        return view('guru.laporan.index', compact(
            'kelasSaya', 'kelasId', 'semester', 'tahunAjaran',
            'kelas', 'siswa', 'aspek', 'rekapNilai', 'rekapPresensi'
        ));
    }

    public function exportPdf(Request $request)
    {
        $kelasId     = $request->id_kelas;
        $semester    = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y').'/'.((int)date('Y')+1);

        $kelas  = Kelas::find($kelasId);
        $siswa  = Siswa::where('id_kelas', $kelasId)->orderBy('nama_siswa')->get();
        $aspek  = AspekPerkembangan::orderBy('urutan')->get();

        $rekapNilai = [];
        foreach ($siswa as $s) {
            foreach ($aspek as $a) {
                $nilaiList = Penilaian::where('id_siswa', $s->id_siswa)
                    ->where('semester', $semester)
                    ->whereHas('indikator', function ($q) use ($a) {
    $q->where('id_aspek', $a->id_aspek);
})
                    ->pluck('nilai');
                $rekapNilai[$s->id_siswa][$a->id_aspek] = $this->getModus($nilaiList->toArray());
            }
        }

        $rekapPresensi = PresensiRaport::whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        $pdf = Pdf::loadView('guru.laporan.pdf', compact(
            'kelas', 'siswa', 'aspek', 'rekapNilai', 'rekapPresensi', 'semester', 'tahunAjaran'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Rekap_'.$kelas->nama_kelas.'_Semester'.$semester.'.pdf');
    }

    // Helper: ambil nilai terbanyak (modus) dari array nilai
    private function getModus(array $nilai): string
    {
        if (empty($nilai)) return '-';
        $urutan  = ['BSB' => 4, 'BSH' => 3, 'MB' => 2, 'BB' => 1];
        $counted = array_count_values($nilai);
        arsort($counted);
        return array_key_first($counted);
    }
}