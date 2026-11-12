<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KatagoriKegiatan;

class KatagoriKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $katagori = [
            ['id_katagori' => 1, 'nama_katagori' => 'Hafalan Surat Pendek & Hadist', 'urutan' => 1],
            ['id_katagori' => 2, 'nama_katagori' => 'Hafalan Doa Sehari-hari',        'urutan' => 2],
            ['id_katagori' => 3, 'nama_katagori' => 'Hafalan Bacaan Sholat',          'urutan' => 3],
            ['id_katagori' => 4, 'nama_katagori' => 'Hafalan Lainnya',                'urutan' => 4],
            ['id_katagori' => 5, 'nama_katagori' => 'Ekstrakurikuler',                'urutan' => 5],
        ];

        foreach ($katagori as $item) {
            // Menggunakan updateOrCreate agar aman dari duplikasi data jika di-seed ulang
            KatagoriKegiatan::updateOrCreate(['id_katagori' => $item['id_katagori']], $item);
        }
    }
}