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
    Schema::create('presensi_raport', function (Blueprint $table) {
        $table->id('id_presensi_raport');
        $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
        $table->string('semester');
        $table->string('tahun_ajaran');
        $table->integer('hadir')->default(0);
        $table->integer('izin')->default(0);
        $table->integer('tanpa_keterangan')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_raport');
    }
};
