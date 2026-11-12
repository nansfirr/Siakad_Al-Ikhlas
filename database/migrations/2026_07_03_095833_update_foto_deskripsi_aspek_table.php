<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deskripsi_aspek', function (Blueprint $table) {

            $table->renameColumn('foto', 'foto1');

            $table->string('foto2')->nullable()->after('foto1');
            $table->string('foto3')->nullable()->after('foto2');

        });
    }

    public function down(): void
    {
        Schema::table('deskripsi_aspek', function (Blueprint $table) {

            $table->dropColumn([
                'foto2',
                'foto3'
            ]);

            $table->renameColumn('foto1', 'foto');

        });
    }
};