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
        Schema::table('profil_usahas', function (Blueprint $table) {
            // Menambahkan kolom instagram setelah kolom nomor_telepon
            $table->string('instagram')->nullable()->after('nomor_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            $table->dropColumn('instagram');
        });
    }
};
