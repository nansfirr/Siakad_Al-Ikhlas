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
    Schema::create('nilai_kegiatan', function (Blueprint $table) {
        $table->id('id_nilai_kegiatan');
        $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
        $table->foreignId('id_item')->constrained('item_kegiatan', 'id_item')->onDelete('cascade');
        $table->enum('nilai', ['BB', 'MB', 'BSH', 'BSB']);
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
        Schema::dropIfExists('nilai_kegiatan');
    }
};
