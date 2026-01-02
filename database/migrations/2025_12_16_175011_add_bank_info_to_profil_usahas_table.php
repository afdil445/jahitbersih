<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            $table->string('nama_bank')->nullable();      // Misal: BRI, BCA
            $table->string('nomor_rekening')->nullable(); // Misal: 1234567890
            $table->string('atas_nama')->nullable();      // Misal: Lhyna Collection
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            //
        });
    }
};
