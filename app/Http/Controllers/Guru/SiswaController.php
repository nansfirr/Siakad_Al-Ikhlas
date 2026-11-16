<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
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

        $kelasId = $request->id_kelas ?? $defaultKelasId;

        $query = Siswa::with('kelas')->orderBy('nama_siswa');

        if ($kelasId !== 'semua' && !empty($kelasId)) {
            $query->where('id_kelas', $kelasId);
        } elseif (!$semuaAkses) {
            $query->whereIn('id_kelas', $kelasSaya->pluck('id_kelas'));
        }

        $siswa = $query->get();

        return view('guru.siswa.index', compact('siswa', 'kelasSaya', 'kelasId', 'semuaAkses'));
    }

    public function create()
    {
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        $kelas = $kelasDiampu->isEmpty()
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        return view('guru.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis'             => 'required|unique:siswa,nis',
            'nama_siswa'      => 'required|string|max:100',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:L,P',
            'anak_ke'         => 'nullable|string|max:20',
            'agama'           => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'alamat'          => 'nullable|string',
            'nama_wali'       => 'nullable|string|max:100',
            'pekerjaan_wali'  => 'nullable|string|max:100',
            'nama_ibu'        => 'required|string|max:100',
            'pekerjaan_ibu'   => 'nullable|string|max:100',
            'id_kelas'        => 'required|exists:kelas,id_kelas',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa = Siswa::create($validated);

        return redirect()
            ->route('guru.siswa.index', ['id_kelas' => $siswa->id_kelas])
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        if ($kelasDiampu->isNotEmpty() && !$kelasDiampu->pluck('id_kelas')->contains($siswa->id_kelas)) {
            abort(403, 'Anda tidak memiliki akses ke siswa di kelas ini.');
        }

        $kelas = $kelasDiampu->isEmpty()
            ? Kelas::orderBy('nama_kelas')->get()
            : $kelasDiampu;

        return view('guru.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $kelasDiampu = Kelas::where('id_user', auth()->id())->get();
        if ($kelasDiampu->isNotEmpty() && !$kelasDiampu->pluck('id_kelas')->contains($siswa->id_kelas)) {
            abort(403, 'Anda tidak memiliki akses ke siswa di kelas ini.');
        }

        $validated = $request->validate([
            'nis'             => 'required|unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
            'nama_siswa'      => 'required|string|max:100',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:L,P',
            'anak_ke'         => 'nullable|string|max:20',
            'agama'           => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'alamat'          => 'nullable|string',
            'nama_wali'       => 'nullable|string|max:100',
            'pekerjaan_wali'  => 'nullable|string|max:100',
            'nama_ibu'        => 'required|string|max:100',
            'pekerjaan_ibu'   => 'nullable|string|max:100',
            'id_kelas'        => 'nullable|exists:kelas,id_kelas',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        unset($validated['foto']);
        if (empty($validated['id_kelas'])) {
            unset($validated['id_kelas']);
        }

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->update($validated);

        return redirect()
            ->route('guru.siswa.index', ['id_kelas' => $siswa->id_kelas])
            ->with('success', 'Biodata siswa & orang tua berhasil diperbarui.');
    }
}
