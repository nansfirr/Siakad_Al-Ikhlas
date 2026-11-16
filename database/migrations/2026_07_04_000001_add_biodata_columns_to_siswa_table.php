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
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('tempat_lahir', 100)->nullable()->after('nama_siswa');
            $table->string('anak_ke', 20)->nullable()->after('jenis_kelamin');
            $table->string('agama', 50)->nullable()->default('Islam')->after('anak_ke');
            $table->string('kewarganegaraan', 50)->nullable()->default('Indonesia')->after('agama');
            $table->text('alamat')->nullable()->after('kewarganegaraan');
            $table->string('pekerjaan_wali', 100)->nullable()->after('nama_wali');
            $table->string('nama_ibu', 100)->nullable()->after('pekerjaan_wali');
            $table->string('pekerjaan_ibu', 100)->nullable()->after('nama_ibu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'anak_ke',
                'agama',
                'kewarganegaraan',
                'alamat',
                'pekerjaan_wali',
                'nama_ibu',
                'pekerjaan_ibu',
            ]);
        });
    }
};
