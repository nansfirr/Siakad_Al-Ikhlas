<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IndikatorPenilaian;

class IndikatorPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $indikator = [
            // Nilai Agama dan Moral (id_aspek: 1)
            ['id_indikator' => 1, 'id_aspek' => 1, 'urutan' => 1, 'capaian_pembelajaran' => 'Terbiasa mengucapkan kalimat pujian terhadap ciptaan Tuhan'],
            ['id_indikator' => 2, 'id_aspek' => 1, 'urutan' => 2, 'capaian_pembelajaran' => 'Menghargai teman dan hormat kepada guru'],
            ['id_indikator' => 3, 'id_aspek' => 1, 'urutan' => 3, 'capaian_pembelajaran' => 'Terbiasa mengucapkan tolong dan terima kasih'],
            ['id_indikator' => 4, 'id_aspek' => 1, 'urutan' => 4, 'capaian_pembelajaran' => 'Mengerti batasan yang boleh dan tidak boleh dilakukan'],

            // Fisik dan Motorik (id_aspek: 2)
            ['id_indikator' => 5, 'id_aspek' => 2, 'urutan' => 1, 'capaian_pembelajaran' => 'Terbiasa memelihara kebersihan diri dan lingkungan'],
            ['id_indikator' => 6, 'id_aspek' => 2, 'urutan' => 2, 'capaian_pembelajaran' => 'Melatih motorik kasar (melompat, berlari, dan meloncat secara terarah)'],
            ['id_indikator' => 7, 'id_aspek' => 2, 'urutan' => 3, 'capaian_pembelajaran' => 'Mampu melempar sesuatu sesuai arah'],
            ['id_indikator' => 8, 'id_aspek' => 2, 'urutan' => 4, 'capaian_pembelajaran' => 'Melatih motorik halus (meremas, menggunting, menggambar, menempel)'],
            ['id_indikator' => 9, 'id_aspek' => 2, 'urutan' => 5, 'capaian_pembelajaran' => 'Mampu menggunakan toilet dengan benar'],

            // Kognitif (id_aspek: 3)
            ['id_indikator' => 10, 'id_aspek' => 3, 'urutan' => 1, 'capaian_pembelajaran' => 'Memiliki perilaku yang mencerminkan sikap ingin tahu'],
            ['id_indikator' => 11, 'id_aspek' => 3, 'urutan' => 2, 'capaian_pembelajaran' => 'Menyelesaikan kegiatan dengan berbagai cara untuk mengatasi masalah'],
            ['id_indikator' => 12, 'id_aspek' => 3, 'urutan' => 3, 'capaian_pembelajaran' => 'Mengenal hewan, jenis dan ciri-cirinya'],
            ['id_indikator' => 13, 'id_aspek' => 3, 'urutan' => 4, 'capaian_pembelajaran' => 'Mencocokan lambang bilangan dengan jumlah bilangan'],
            ['id_indikator' => 14, 'id_aspek' => 3, 'urutan' => 5, 'capaian_pembelajaran' => 'Mengenal tanaman dan bagiannya'],

            // Sosial Emosi (id_aspek: 4)
            ['id_indikator' => 15, 'id_aspek' => 4, 'urutan' => 1, 'capaian_pembelajaran' => 'Menyampaikan keinginan dengan santun'],
            ['id_indikator' => 16, 'id_aspek' => 4, 'urutan' => 2, 'capaian_pembelajaran' => 'Memiliki inisiatif untuk melakukan sesuatu tanpa bantuan'],
            ['id_indikator' => 17, 'id_aspek' => 4, 'urutan' => 3, 'capaian_pembelajaran' => 'Senang berbagi makanan atau mainan'],
            ['id_indikator' => 18, 'id_aspek' => 4, 'urutan' => 4, 'capaian_pembelajaran' => 'Mengerjakan sesuatu dengan tuntas'],

            // Bahasa (id_aspek: 5)
            ['id_indikator' => 19, 'id_aspek' => 5, 'urutan' => 1, 'capaian_pembelajaran' => 'Menjawab dengan cepat ketika ditanya'],
            ['id_indikator' => 20, 'id_aspek' => 5, 'urutan' => 2, 'capaian_pembelajaran' => 'Menceritakan kembali apa yang sudah didengar'],
            ['id_indikator' => 21, 'id_aspek' => 5, 'urutan' => 3, 'capaian_pembelajaran' => 'Mengenali huruf pada namanya dan dapat menuliskannya'],

            // Seni (id_aspek: 6)
            ['id_indikator' => 22, 'id_aspek' => 6, 'urutan' => 1, 'capaian_pembelajaran' => 'Mengenal berbagai karya dan aktivitas seni'],
            ['id_indikator' => 23, 'id_aspek' => 6, 'urutan' => 2, 'capaian_pembelajaran' => 'Menghargai hasil karya dalam bentuk gambar, gerak dan bentuk seni lainnya'],
            ['id_indikator' => 24, 'id_aspek' => 6, 'urutan' => 3, 'capaian_pembelajaran' => 'Menunjukkan rasa ingin tahu melalui observasi, eksplorasi, eksperimen dan media belajar'],
        ];

        foreach ($indikator as $item) {
            // Menggunakan updateOrCreate berdasarkan id_indikator agar aman dari duplikasi data
            IndikatorPenilaian::updateOrCreate(['id_indikator' => $item['id_indikator']], $item);
        }
    }
}