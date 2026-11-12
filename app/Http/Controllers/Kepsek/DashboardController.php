<?php
namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Penilaian;
use App\Models\AspekPerkembangan;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_siswa' => Siswa::count(),
            'total_kelas' => Kelas::count(),
            'total_guru'  => User::where('role', 'guru')->count(),
        ];

        // Statistik distribusi nilai per aspek (untuk grafik)
        $aspek  = AspekPerkembangan::orderBy('urutan')->get();
        $grafik = [];
       foreach ($aspek as $a) {
    foreach (['BB','MB','BSH','BSB'] as $n) {
        $grafik[$a->nama_aspek][$n] = Penilaian::where('nilai', $n)
            ->whereHas('indikator', function ($q) use ($a) {
                $q->where('id_aspek', $a->id_aspek);
            })
            ->count();
    }
}

        // Daftar kelas dan jumlah siswa
        $kelasList = Kelas::with(['siswa', 'user'])->get();

        return view('kepsek.dashboard', compact('data', 'grafik', 'aspek', 'kelasList'));
    }
}