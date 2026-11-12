<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AspekPerkembangan;
use App\Models\DeskripsiAspek;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $kelasSaya = Kelas::where('id_user', auth()->id())->get();

        if ($kelasSaya->isEmpty()) {
            return back()->with('error', 'Anda belum memiliki kelas yang diampu.');
        }

        $kelasId = $request->id_kelas ?? $kelasSaya->first()->id_kelas;
        $semester = $request->semester ?? '1';

        $siswa = Siswa::where('id_kelas', $kelasId)
            ->orderBy('nama_siswa')
            ->get();

        return view('guru.penilaian.index', compact(
            'kelasSaya',
            'kelasId',
            'semester',
            'siswa'
        ));
    }

    public function show(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $semester = $request->semester ?? '1';

        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);

        $aspek = AspekPerkembangan::with([
            'indikatorPenilaian' => function ($q) {
                $q->orderBy('urutan');
            }
        ])->orderBy('urutan')->get();

        $penilaianExisting = Penilaian::where('id_siswa', $siswa->id_siswa)
            ->where('semester', $semester)
            ->get()
            ->keyBy('id_indikator');

        $deskripsiAspek = DeskripsiAspek::where('id_siswa', $siswa->id_siswa)
            ->where('semester', $semester)
            ->get()
            ->keyBy('id_aspek');

        return view('guru.penilaian.show', compact(
            'siswa',
            'semester',
            'aspek',
            'penilaianExisting',
            'deskripsiAspek'
        ));
    }

    public function store(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $tahunAjaran = date('Y') . '/' . (date('Y') + 1);

        $request->validate([
            'semester' => 'required|in:1,2',
            'penilaian' => 'required|array',
            'penilaian.*.nilai' => 'required|in:BB,MB,BSH,BSB',
            'deskripsi' => 'nullable|array',
            'foto' => 'nullable|array',
            'foto.*.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | SIMPAN NILAI INDIKATOR
            |--------------------------------------------------------------------------
            */
            foreach ($request->penilaian as $idIndikator => $data) {

                Penilaian::updateOrCreate(
                    [
                        'id_siswa' => $siswa->id_siswa,
                        'id_indikator' => $idIndikator,
                        'semester' => $request->semester,
                    ],
                    [
                        'nilai' => $data['nilai'],
                        'tahun_ajaran' => $tahunAjaran,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN DESKRIPSI + 1-3 FOTO PER ASPEK
            |--------------------------------------------------------------------------
            */
            if ($request->has('deskripsi')) {

                foreach ($request->deskripsi as $idAspek => $isiDeskripsi) {

                    $dataLama = DeskripsiAspek::where('id_siswa', $siswa->id_siswa)
                        ->where('id_aspek', $idAspek)
                        ->where('semester', $request->semester)
                        ->where('tahun_ajaran', $tahunAjaran)
                        ->first();

                    $foto1 = $dataLama->foto1 ?? null;
                    $foto2 = $dataLama->foto2 ?? null;
                    $foto3 = $dataLama->foto3 ?? null;

                    // FOTO 1
                    if ($request->hasFile("foto.$idAspek.0")) {
                        if ($foto1 && Storage::disk('public')->exists($foto1)) {
                            Storage::disk('public')->delete($foto1);
                        }
                        $foto1 = $request->file("foto.$idAspek.0")
                            ->store('deskripsi_aspek', 'public');
                    }

                    // FOTO 2
                    if ($request->hasFile("foto.$idAspek.1")) {
                        if ($foto2 && Storage::disk('public')->exists($foto2)) {
                            Storage::disk('public')->delete($foto2);
                        }
                        $foto2 = $request->file("foto.$idAspek.1")
                            ->store('deskripsi_aspek', 'public');
                    }

                    // FOTO 3
                    if ($request->hasFile("foto.$idAspek.2")) {
                        if ($foto3 && Storage::disk('public')->exists($foto3)) {
                            Storage::disk('public')->delete($foto3);
                        }
                        $foto3 = $request->file("foto.$idAspek.2")
                            ->store('deskripsi_aspek', 'public');
                    }

                    DeskripsiAspek::updateOrCreate(
                        [
                            'id_siswa' => $siswa->id_siswa,
                            'id_aspek' => $idAspek,
                            'semester' => $request->semester,
                            'tahun_ajaran' => $tahunAjaran,
                        ],
                        [
                            'deskripsi' => $isiDeskripsi,
                            'foto1' => $foto1,
                            'foto2' => $foto2,
                            'foto3' => $foto3,
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()
                ->route('guru.penilaian.index', [
                    'semester' => $request->semester
                ])
                ->with('success', 'Penilaian berhasil disimpan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}