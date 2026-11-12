<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_siswa'  => Siswa::count(),
            'total_kelas'  => Kelas::count(),
            'total_guru'   => User::where('role', 'guru')->count(),
            'total_kepsek' => User::where('role', 'kepsek')->count(),
        ];

        return view('admin.dashboard', compact('data'));
    }
}