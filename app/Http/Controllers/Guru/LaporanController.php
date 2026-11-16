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
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        $semuaAkses  = $kelasDiampu->isEmpty();

        $kelasSaya = $semuaAkses
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        $defaultKelasId = $semuaAkses
            ? 'semua'
            : ($kelasSaya->first()?->id_kelas ?? 'semua');

        $kelasId     = $request->id_kelas ?? $defaultKelasId;
        $semester    = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y').'/'.((int)date('Y')+1);

        $kelas = ($kelasId !== 'semua' && !empty($kelasId))
            ? Kelas::find($kelasId)
            : (object) ['nama_kelas' => 'Semua Kelas'];

        $query = Siswa::with('kelas')->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $siswa = $query->get();

        $aspek = AspekPerkembangan::orderBy('urutan')->get();

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

        return view('guru.laporan.index', compact(
            'kelasSaya', 'kelasId', 'semuaAkses', 'semester', 'tahunAjaran',
            'kelas', 'siswa', 'aspek', 'rekapNilai', 'rekapPresensi'
        ));
    }

    public function exportPdf(Request $request)
    {
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        $semuaAkses  = $kelasDiampu->isEmpty();

        $kelasSaya = $semuaAkses
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        $kelasId     = $request->id_kelas ?? 'semua';
        $semester    = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y').'/'.((int)date('Y')+1);

        $kelas = ($kelasId !== 'semua' && !empty($kelasId))
            ? Kelas::find($kelasId)
            : (object) ['nama_kelas' => 'Semua Kelas'];

        $query = Siswa::with('kelas')->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $siswa = $query->get();

        $aspek = AspekPerkembangan::orderBy('urutan')->get();

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

        $namaKelasFile = str_replace(' ', '_', $kelas->nama_kelas ?? 'Semua_Kelas');

        $pdf = Pdf::loadView('guru.laporan.pdf', compact(
            'kelas', 'siswa', 'aspek', 'rekapNilai', 'rekapPresensi', 'semester', 'tahunAjaran'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Rekap_'.$namaKelasFile.'_Semester'.$semester.'.pdf');
    }

    private function getModus(array $nilai): string
    {
        if (empty($nilai)) return '-';
        $counted = array_count_values($nilai);
        arsort($counted);
        return array_key_first($counted);
    }
}
