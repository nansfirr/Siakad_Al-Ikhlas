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
        $kelasSaya = Kelas::where('id_user', auth()->id())->get();
        
        if ($kelasSaya->isEmpty()) {
            return back()->with('error', 'Anda belum memiliki kelas yang diampu.');
        }

        $kelasId     = $request->id_kelas ?? $kelasSaya->first()->id_kelas;
        $semester    = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y').'/'.((int)date('Y')+1);

        $siswa = Siswa::where('id_kelas', $kelasId)->orderBy('nama_siswa')->get();

        $antropometriData = Antropometri::whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        return view('guru.antropometri.index', compact(
            'kelasSaya', 'kelasId', 'semester', 'tahunAjaran', 'siswa', 'antropometriData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kelas'     => 'required',
            'semester'     => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
            'antropometri' => 'required|array',
            'antropometri.*.tinggi_badan'   => 'required|numeric|min:0',
            'antropometri.*.berat_badan'    => 'required|numeric|min:0',
            'antropometri.*.lingkar_kepala' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->antropometri as $id_siswa => $data) {
                Antropometri::updateOrCreate(
                    [
                        'id_siswa'     => $id_siswa,
                        'semester'     => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ],
                    [
                        'tinggi_badan'   => $data['tinggi_badan'],
                        'berat_badan'    => $data['berat_badan'],
                        'lingkar_kepala' => $data['lingkar_kepala'],
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