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
        Schema::table('users', function (Blueprint $table) {
            // Ditambahkan opsi 'kepsek' ke dalam ENUM role
            $table->enum('role', ['admin', 'guru', 'kepsek'])->default('guru')->after('email');
        });
    }

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};
