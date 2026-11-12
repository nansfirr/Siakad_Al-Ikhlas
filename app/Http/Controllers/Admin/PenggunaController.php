<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::whereIn('role', ['guru', 'kepsek'])->orderBy('name')->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:guru,kepsek',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,'.$pengguna->id,
            'password' => 'nullable|min:6|confirmed',
            'role'     => 'required|in:guru,kepsek',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        // 1. Mencegah user menghapus akun yang sedang login
        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun yang sedang Anda gunakan.');
        }

        // 2. Mencegah penghapusan jika user masih terdaftar sebagai wali kelas
        // Pastikan relasi 'kelas' sudah didefinisikan di Model User
        if ($pengguna->kelas()->exists()) {
            return back()->with('error', 'Tidak bisa menghapus! Pengguna masih terdaftar sebagai wali kelas.');
        }

        // 3. Hapus data jika aman
        $pengguna->delete();
        
        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}