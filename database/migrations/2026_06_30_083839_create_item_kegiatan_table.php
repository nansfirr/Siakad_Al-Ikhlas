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
    Schema::create('item_kegiatan', function (Blueprint $table) {
        $table->id('id_item');
       $table->foreignId('id_katagori')->constrained('katagori_kegiatan', 'id_katagori')->onDelete('cascade');
        $table->string('nama_item');
        $table->integer('urutan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_kegiatan');
    }
};
