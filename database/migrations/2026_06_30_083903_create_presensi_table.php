<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {

            $table->id('id_presensi');

            $table->foreignId('id_siswa')
                  ->constrained('siswa', 'id_siswa')
                  ->onDelete('cascade');

            $table->date('tanggal');

            // Tambahan baru
            $table->string('semester', 10);

            $table->string('tahun_ajaran', 20);

            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'tanpa_keterangan'
            ]);

            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};