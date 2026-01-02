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
        Schema::table('pesan_kontaks', function (Blueprint $table) {
            // Tambahkan kolom 'balasan' setelah kolom 'pesan'
            // Kita set nullable() karena pesan baru belum ada balasannya
            $table->text('balasan')->nullable()->after('pesan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan_kontaks', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn('balasan');
        });
    }
};