<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');

            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->onDelete('cascade');

            $table->foreignId('id_indikator')
                ->constrained('indikator_penilaian', 'id_indikator')
                ->onDelete('cascade');

            $table->enum('nilai', ['BB', 'MB', 'BSH', 'BSB']);

            $table->string('semester');
            $table->string('tahun_ajaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};