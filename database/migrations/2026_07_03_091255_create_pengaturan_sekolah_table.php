<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_sekolah', function (Blueprint $table) {

            $table->id('id_pengaturan');

            $table->string('nama_sekolah');
            $table->text('alamat')->nullable();

            $table->string('telepon')->nullable();
            $table->string('email')->nullable();

            $table->string('kepala_sekolah')->nullable();
            $table->string('nip_kepala')->nullable();

            $table->string('logo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_sekolah');
    }
};