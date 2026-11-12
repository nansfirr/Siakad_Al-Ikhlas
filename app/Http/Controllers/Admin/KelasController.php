<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        // Menggunakan with('user') untuk menghindari N+1 query saat menampilkan nama guru
        $kelas = Kelas::with('user')->orderBy('tahun_ajaran', 'desc')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $guru = User::where('role', 'guru')->get();
        return view('admin.kelas.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas'   => 'required|string|max:100',
            'tahun_ajaran' => 'required|string|max:20',
            'id_user'      => 'required|exists:users,id',
        ]);

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $guru = User::where('role', 'guru')->get();
        return view('admin.kelas.edit', compact('kelas', 'guru'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas'   => 'required|string|max:100',
            'tahun_ajaran' => 'required|string|max:20',
            'id_user'      => 'required|exists:users,id',
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        try {
            // Cek apakah ada siswa di kelas ini sebelum menghapus
            if ($kelas->siswa()->exists()) {
                return back()->with('error', 'Tidak bisa menghapus, kelas masih memiliki siswa!');
            }
            
            $kelas->delete();
            return redirect()->route('admin.kelas.index')
                ->with('success', 'Data kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}