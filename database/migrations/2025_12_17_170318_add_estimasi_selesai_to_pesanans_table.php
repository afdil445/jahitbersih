<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Hapus '->after(...)' agar tidak error mencari kolom deskripsi
            $table->date('estimasi_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Hapus kolom estimasi_selesai jika migration di-rollback
            $table->dropColumn('estimasi_selesai');
        });
    }
};