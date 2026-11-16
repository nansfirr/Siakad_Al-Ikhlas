<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RefleksiGuru;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefleksiController extends Controller
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

        $refleksiData = RefleksiGuru::whereIn('id_siswa', $siswa->pluck('id_siswa'))
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        return view('guru.refleksi.index', compact(
            'kelasSaya', 'kelasId', 'semuaAkses', 'semester', 'tahunAjaran', 'siswa', 'refleksiData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kelas'     => 'nullable',
            'semester'     => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
            'refleksi'     => 'required|array',
            'refleksi.*.catatan_guru' => 'required|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->refleksi as $id_siswa => $data) {
                RefleksiGuru::updateOrCreate(
                    [
                        'id_siswa'     => $id_siswa,
                        'semester'     => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ],
                    ['catatan_guru' => $data['catatan_guru']]
                );
            }
            DB::commit();
            return redirect()->route('guru.refleksi.index', [
                'id_kelas'     => $request->id_kelas,
                'semester'     => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
            ])->with('success', 'Refleksi guru berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan refleksi: ' . $e->getMessage());
        }
    }
}
