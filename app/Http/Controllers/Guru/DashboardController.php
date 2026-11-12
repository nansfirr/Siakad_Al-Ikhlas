<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard Guru berdasarkan kelas yang diampu.
     */
    public function index()
    {
        // 1. Ambil data kelas yang diampu oleh guru yang sedang login
        // Catatan: Pastikan nama kolom foreign key di tabel kelas adalah 'id_user' atau 'user_id'
        $kelas = Kelas::where('id_user', auth()->id())->get();

        // 2. Hitung total siswa yang berada di kelas-kelas milik guru tersebut
        // Menggunakan primary key dari tabel kelas (jika primary key Anda 'id', gunakan 'id')
        $total_siswa = Siswa::whereIn('id_kelas', $kelas->pluck('id_kelas'))->count();

        return view('guru.dashboard', compact('kelas', 'total_siswa'));
    }
}