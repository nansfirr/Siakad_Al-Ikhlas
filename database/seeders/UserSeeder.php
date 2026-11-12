<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama (Hak Akses: Mengelola data master & user)
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@tkal-ikhlas.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // 2. Akun Kepala Sekolah (Hak Akses: Memantau statistik & laporan akademik)
        User::create([
            'name'     => 'Kepala Sekolah TK',
            'email'    => 'kepsek@tkal-ikhlas.sch.id',
            'password' => Hash::make('kepsek123'),
            'role'     => 'kepsek',
        ]);
    }
}