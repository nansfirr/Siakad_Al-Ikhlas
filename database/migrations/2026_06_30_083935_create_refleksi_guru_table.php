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
    Schema::create('refleksi_guru', function (Blueprint $table) {
        $table->id('id_refleksi');
        $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
        $table->text('catatan_guru');
        $table->string('semester');
        $table->string('tahun_ajaran');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refleksi_guru');
    }
};
