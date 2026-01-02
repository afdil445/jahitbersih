<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kita hapus kolom lama yang namanya panjang ini
            $table->dropColumn('deskripsi_pesanan');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Jaga-jaga kalau rollback
            $table->text('deskripsi_pesanan')->nullable();
        });
    }
};