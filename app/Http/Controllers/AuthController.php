<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses data login yang dikirim dari form
    public function login(Request $request)
    {
        // 1. Validasi inputan form
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba autentikasi pengguna ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Ambil role user untuk mengarahkan ke dashboard yang sesuai
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'kepsek') {
                return redirect()->intended('/kepsek/dashboard');
            } elseif ($role === 'guru') {
                return redirect()->intended('/guru/dashboard');
            }

            return redirect('/');
        }

        // 4. Jika login gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses proses logout (keluar dari sistem)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}