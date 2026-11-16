<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\PresensiRaport;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    /**
     * Menampilkan daftar siswa untuk presensi
     */
    public function index(Request $request)
    {
        $kelasDiampu = Kelas::where('id_user', Auth::id())->get();
        $semuaAkses  = $kelasDiampu->isEmpty();

        $kelasSaya = $semuaAkses
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        $defaultKelasId = $semuaAkses
            ? 'semua'
            : ($kelasSaya->first()?->id_kelas ?? 'semua');

        $kelasId = $request->id_kelas ?? $defaultKelasId;

        $tanggal = $request->tanggal ?? date('Y-m-d');

        $semester = $request->semester ?? '1';

        $tahunAjaran = $request->tahun_ajaran
            ?? date('Y') . '/' . (date('Y') + 1);

        $query = Siswa::with('kelas')->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $siswa = $query->get();

        $presensiHariIni = Presensi::where('tanggal', $tanggal)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->get()
            ->keyBy('id_siswa');

        return view('guru.presensi.index', compact(
            'kelasSaya',
            'kelasId',
            'semuaAkses',
            'tanggal',
            'semester',
            'tahunAjaran',
            'siswa',
            'presensiHariIni'
        ));
    }

    /**
     * Simpan Presensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas'          => 'nullable',
            'tanggal'           => 'required|date',
            'semester'          => 'required',
            'tahun_ajaran'      => 'required',
            'presensi'          => 'required|array',
            'presensi.*.status' => 'required|in:hadir,izin,sakit,tanpa_keterangan',
        ]);

        DB::beginTransaction();

        try {

            foreach ($request->presensi as $id_siswa => $data) {

                Presensi::updateOrCreate(
                    [
                        'id_siswa'     => $id_siswa,
                        'tanggal'      => $request->tanggal,
                        'semester'     => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ],
                    [
                        'status'     => $data['status'],
                        'keterangan' => $data['keterangan'] ?? null,
                    ]
                );

                $this->updatePresensiRaport(
                    $id_siswa,
                    $request->semester,
                    $request->tahun_ajaran
                );
            }

            DB::commit();

            return redirect()->route('guru.presensi.index', [
                'id_kelas'     => $request->id_kelas,
                'tanggal'      => $request->tanggal,
                'semester'     => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
            ])->with('success', 'Data presensi berhasil disimpan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Sinkronisasi ke tabel presensi_raport
     */
    private function updatePresensiRaport(
        int $id_siswa,
        string $semester,
        string $tahunAjaran
    ): void {

        $rekap = Presensi::where('id_siswa', $id_siswa)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        PresensiRaport::updateOrCreate(
            [
                'id_siswa'     => $id_siswa,
                'semester'     => $semester,
                'tahun_ajaran' => $tahunAjaran,
            ],
            [
                'hadir'            => $rekap->where('status', 'hadir')->count(),
                'izin'             => $rekap->where('status', 'izin')->count(),
                'sakit'            => $rekap->where('status', 'sakit')->count(),
                'tanpa_keterangan' => $rekap->where('status', 'tanpa_keterangan')->count(),
            ]
        );
    }
}
