<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Antropometri;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntropometriController extends Controller
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

        $query = Siswa::with('kelas')->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $siswa = $query->get();

        $antropometriData = Antropometri::whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        return view('guru.antropometri.index', compact(
            'kelasSaya', 'kelasId', 'semuaAkses', 'semester', 'tahunAjaran', 'siswa', 'antropometriData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kelas'     => 'nullable',
            'semester'     => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
            'antropometri' => 'required|array',
            'antropometri.*.tinggi_badan'   => 'nullable|numeric|min:0',
            'antropometri.*.berat_badan'    => 'nullable|numeric|min:0',
            'antropometri.*.lingkar_kepala' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->antropometri as $id_siswa => $data) {
                if (
                    ($data['tinggi_badan'] ?? '') === '' &&
                    ($data['berat_badan'] ?? '') === '' &&
                    ($data['lingkar_kepala'] ?? '') === ''
                ) {
                    continue;
                }
                Antropometri::updateOrCreate(
                    [
                        'id_siswa'     => $id_siswa,
                        'semester'     => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ],
                    [
                        'tinggi_badan'   => $data['tinggi_badan'] ?? 0,
                        'berat_badan'    => $data['berat_badan'] ?? 0,
                        'lingkar_kepala' => $data['lingkar_kepala'] ?? 0,
                    ]
                );
            }
            DB::commit();
            return redirect()->route('guru.antropometri.index', [
                'id_kelas'     => $request->id_kelas,
                'semester'     => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
            ])->with('success', 'Data antropometri berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
