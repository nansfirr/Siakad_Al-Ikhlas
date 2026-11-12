<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemKegiatan;

class ItemKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Hafalan Surat Pendek & Hadist (id_katagori: 1)
            ['id_item' => 1, 'id_katagori' => 1, 'urutan' => 1,  'nama_item' => 'Surat Al-Fatihah'],
            ['id_item' => 2, 'id_katagori' => 1, 'urutan' => 2,  'nama_item' => 'Surat An-Nas'],
            ['id_item' => 3, 'id_katagori' => 1, 'urutan' => 3,  'nama_item' => 'Surat Al-Falaq'],
            ['id_item' => 4, 'id_katagori' => 1, 'urutan' => 4,  'nama_item' => 'Surat Al-Ikhlas'],
            ['id_item' => 5, 'id_katagori' => 1, 'urutan' => 5,  'nama_item' => 'Surat Al-Lahab'],
            ['id_item' => 6, 'id_katagori' => 1, 'urutan' => 6,  'nama_item' => 'Surat An-Nasr'],
            ['id_item' => 7, 'id_katagori' => 1, 'urutan' => 7,  'nama_item' => 'Surat Al-Kafirun'],
            ['id_item' => 8, 'id_katagori' => 1, 'urutan' => 8,  'nama_item' => 'Hadist Kebersihan'],
            ['id_item' => 9, 'id_katagori' => 1, 'urutan' => 9,  'nama_item' => 'Hadist Larangan Marah'],
            ['id_item' => 10, 'id_katagori' => 1, 'urutan' => 10, 'nama_item' => 'Hadist Larangan Minum Sambil Berdiri'],
            ['id_item' => 11, 'id_katagori' => 1, 'urutan' => 11, 'nama_item' => 'Hadist Surga Di Bawah Telapak Kaki Ibu'],
            ['id_item' => 12, 'id_katagori' => 1, 'urutan' => 12, 'nama_item' => 'Hadist Menyayangi Makhluk Allah'],
            ['id_item' => 13, 'id_katagori' => 1, 'urutan' => 13, 'nama_item' => 'Hadist Sholat Pada Waktunya'],
            ['id_item' => 14, 'id_katagori' => 1, 'urutan' => 14, 'nama_item' => 'Hadist Senyum Itu Sedekah'],

            // Hafalan Doa Sehari-hari (id_katagori: 2)
            ['id_item' => 15, 'id_katagori' => 2, 'urutan' => 1,  'nama_item' => 'Doa Sebelum Makan'],
            ['id_item' => 16, 'id_katagori' => 2, 'urutan' => 2,  'nama_item' => 'Doa Sesudah Makan'],
            ['id_item' => 17, 'id_katagori' => 2, 'urutan' => 3,  'nama_item' => 'Doa Sebelum Tidur'],
            ['id_item' => 18, 'id_katagori' => 2, 'urutan' => 4,  'nama_item' => 'Doa Bangun Tidur'],
            ['id_item' => 19, 'id_katagori' => 2, 'urutan' => 5,  'nama_item' => 'Doa Kedua Orang Tua'],
            ['id_item' => 20, 'id_katagori' => 2, 'urutan' => 6,  'nama_item' => 'Doa Masuk Kamar Mandi'],
            ['id_item' => 21, 'id_katagori' => 2, 'urutan' => 7,  'nama_item' => 'Doa Keluar Kamar Mandi'],
            ['id_item' => 22, 'id_katagori' => 2, 'urutan' => 8,  'nama_item' => 'Doa Kebaikan Dunia Akhirat'],
            ['id_item' => 23, 'id_katagori' => 2, 'urutan' => 9,  'nama_item' => 'Doa Masuk Rumah'],
            ['id_item' => 24, 'id_katagori' => 2, 'urutan' => 10, 'nama_item' => 'Doa Keluar Rumah'],
            ['id_item' => 25, 'id_katagori' => 2, 'urutan' => 11, 'nama_item' => 'Doa Ketika Hujan'],

            // Hafalan Bacaan Sholat (id_katagori: 3)
            ['id_item' => 26, 'id_katagori' => 3, 'urutan' => 1, 'nama_item' => 'Doa Iftitah'],
            ['id_item' => 27, 'id_katagori' => 3, 'urutan' => 2, 'nama_item' => "Ruku'"],
            ['id_item' => 28, 'id_katagori' => 3, 'urutan' => 3, 'nama_item' => "I'tidal"],
            ['id_item' => 29, 'id_katagori' => 3, 'urutan' => 4, 'nama_item' => 'Sujud'],
            ['id_item' => 30, 'id_katagori' => 3, 'urutan' => 5, 'nama_item' => 'Duduk di Antara Dua Sujud'],
            ['id_item' => 31, 'id_katagori' => 3, 'urutan' => 6, 'nama_item' => 'Tahiyat'],

            // Hafalan Lainnya (id_katagori: 4)
            ['id_item' => 32, 'id_katagori' => 4, 'urutan' => 1,  'nama_item' => 'Rukun Iman'],
            ['id_item' => 33, 'id_katagori' => 4, 'urutan' => 2,  'nama_item' => 'Rukun Islam'],
            ['id_item' => 34, 'id_katagori' => 4, 'urutan' => 3,  'nama_item' => 'Nama-Nama Bulan Islam'],
            ['id_item' => 35, 'id_katagori' => 4, 'urutan' => 4,  'nama_item' => 'Nama-Nama Bulan Masehi'],
            ['id_item' => 36, 'id_katagori' => 4, 'urutan' => 5,  'nama_item' => '25 Nabi Allah'],
            ['id_item' => 37, 'id_katagori' => 4, 'urutan' => 6,  'nama_item' => '10 Malaikat Allah'],
            ['id_item' => 38, 'id_katagori' => 4, 'urutan' => 7,  'nama_item' => 'Pancasila'],
            ['id_item' => 39, 'id_katagori' => 4, 'urutan' => 8,  'nama_item' => 'Lambang Pancasila'],
            ['id_item' => 40, 'id_katagori' => 4, 'urutan' => 9,  'nama_item' => 'Mengenal Hijaiyah'],
            ['id_item' => 41, 'id_katagori' => 4, 'urutan' => 10, 'nama_item' => 'Asmaul Husna'],

            // Ekstrakurikuler (id_katagori: 5)
            ['id_item' => 42, 'id_katagori' => 5, 'urutan' => 1, 'nama_item' => 'Rebana'],
            ['id_item' => 43, 'id_katagori' => 5, 'urutan' => 2, 'nama_item' => 'Tapak Suci'],
            ['id_item' => 44, 'id_katagori' => 5, 'urutan' => 3, 'nama_item' => 'Menari'],
        ];

        foreach ($items as $item) {
            // Menggunakan updateOrCreate berdasarkan id_item agar aman dari duplikasi data jika di-seed ulang
            ItemKegiatan::updateOrCreate(['id_item' => $item['id_item']], $item);
        }
    }
}