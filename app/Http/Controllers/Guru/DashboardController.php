<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard Guru.
     * Jika guru tidak memiliki kelas khusus yang diampu, tampilkan semua kelas & semua siswa.
     */
    public function index()
    {
        $kelas = Kelas::with('siswa')->where('id_user', auth()->id())->get();

        if ($kelas->isEmpty()) {
            $kelas = Kelas::with('siswa')->orderBy('nama_kelas')->get();
            $total_siswa = Siswa::count();
        } else {
            $total_siswa = Siswa::whereIn('id_kelas', $kelas->pluck('id_kelas'))->count();
        }

        return view('guru.dashboard', compact('kelas', 'total_siswa'));
    }
}
