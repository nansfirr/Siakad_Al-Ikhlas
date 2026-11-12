<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deskripsi_aspek', function (Blueprint $table) {

            $table->id('id_deskripsi');

            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->cascadeOnDelete();

            $table->foreignId('id_aspek')
                ->constrained('aspek_perkembangan', 'id_aspek')
                ->cascadeOnDelete();

            $table->string('semester');

            $table->string('tahun_ajaran');

            $table->text('deskripsi')->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deskripsi_aspek');
    }
};