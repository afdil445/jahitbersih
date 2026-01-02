<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Cek apakah kolom 'alamat' ada? Jika ada, hapus!
            if (Schema::hasColumn('pesanans', 'alamat')) {
                $table->dropColumn('alamat');
            }

            // Cek apakah kolom 'tanggal' (sisa lama) ada? Jika ada, hapus!
            // (Karena kita sekarang pakainya 'estimasi_selesai')
            if (Schema::hasColumn('pesanans', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kembalikan jika rollback (Opsional)
            $table->text('alamat')->nullable();
        });
    }
};