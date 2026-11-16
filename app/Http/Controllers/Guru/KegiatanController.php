<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\NilaiKegiatan;
use App\Models\KatagoriKegiatan;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
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

        $kelasId  = $request->id_kelas ?? $defaultKelasId;
        $semester = $request->semester ?? '1';

        $query = Siswa::with(['kelas', 'nilaiKegiatan'])->orderBy('nama_siswa');
        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }
        $siswa = $query->get();

        return view('guru.kegiatan.index', compact('kelasSaya', 'kelasId', 'semuaAkses', 'semester', 'siswa'));
    }

    public function show(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $semester = $request->semester ?? '1';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y').'/'.((int)date('Y')+1);

        $katagori = KatagoriKegiatan::with(['itemKegiatan' => function($q) {
            $q->orderBy('urutan');
        }])->orderBy('urutan')->get();

        $nilaiExisting = NilaiKegiatan::where('id_siswa', $siswa->id_siswa)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_item');

        return view('guru.kegiatan.show', compact(
            'siswa', 'semester', 'tahunAjaran', 'katagori', 'nilaiExisting'
        ));
    }

    public function store(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'semester'     => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
            'nilai'        => 'required|array',
            'nilai.*.nilai'=> 'required|in:BB,MB,BSH,BSB',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->nilai as $id_item => $data) {
                NilaiKegiatan::updateOrCreate(
                    [
                        'id_siswa'     => $siswa->id_siswa,
                        'id_item'      => $id_item,
                        'semester'     => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ],
                    ['nilai' => $data['nilai']]
                );
            }
            DB::commit();
            return redirect()->route('guru.kegiatan.index', [
                'id_kelas' => $siswa->id_kelas,
                'semester' => $request->semester,
            ])->with('success', "Penilaian kegiatan {$siswa->nama_siswa} berhasil disimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan penilaian kegiatan.');
        }
    }
}
