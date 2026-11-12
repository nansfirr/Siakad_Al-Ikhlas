<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AspekPerkembangan;

class AspekPerkembanganSeeder extends Seeder
{
    public function run(): void
    {
        $aspek = [
            ['id_aspek' => 1, 'nama_aspek' => 'Nilai Agama dan Moral', 'urutan' => 1],
            ['id_aspek' => 2, 'nama_aspek' => 'Fisik dan Motorik',       'urutan' => 2],
            ['id_aspek' => 3, 'nama_aspek' => 'Kognitif',                'urutan' => 3],
            ['id_aspek' => 4, 'nama_aspek' => 'Sosial Emosi',            'urutan' => 4],
            ['id_aspek' => 5, 'nama_aspek' => 'Bahasa',                  'urutan' => 5],
            ['id_aspek' => 6, 'nama_aspek' => 'Seni',                    'urutan' => 6],
        ];

        foreach ($aspek as $item) {
            // Menggunakan updateOrCreate agar aman dari duplikasi data jika di-seed ulang
            AspekPerkembangan::updateOrCreate(['id_aspek' => $item['id_aspek']], $item);
        }
    }
}