<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
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

        Siswa::create($validated);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis'             => 'required|unique:siswa,nis,'.$siswa->id_siswa.',id_siswa',
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

        unset($validated['foto']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
