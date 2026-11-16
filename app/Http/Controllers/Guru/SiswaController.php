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
        $kelasSaya = Kelas::where('id_user', auth()->id())->get();

        if ($kelasSaya->isEmpty()) {
            return view('guru.siswa.index', [
                'siswa'     => collect(),
                'kelasSaya' => collect(),
                'kelasId'   => null,
            ]);
        }

        $kelasId = $request->id_kelas ?? $kelasSaya->first()->id_kelas;

        $siswa = Siswa::with('kelas')
            ->where('id_kelas', $kelasId)
            ->orderBy('nama_siswa')
            ->get();

        return view('guru.siswa.index', compact('siswa', 'kelasSaya', 'kelasId'));
    }

    public function edit(Siswa $siswa)
    {
        $kelasSayaIds = Kelas::where('id_user', auth()->id())->pluck('id_kelas');
        if (!$kelasSayaIds->contains($siswa->id_kelas)) {
            abort(403, 'Anda tidak memiliki akses ke siswa di kelas ini.');
        }

        return view('guru.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $kelasSayaIds = Kelas::where('id_user', auth()->id())->pluck('id_kelas');
        if (!$kelasSayaIds->contains($siswa->id_kelas)) {
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
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        unset($validated['foto']);

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
