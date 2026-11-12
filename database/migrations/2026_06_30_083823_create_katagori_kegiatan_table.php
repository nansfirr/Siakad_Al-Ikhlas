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
    Schema::create('katagori_kegiatan', function (Blueprint $table) {
        $table->id('id_katagori');
        $table->string('nama_katagori');
        $table->integer('urutan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katagori_kegiatan');
    }
};
