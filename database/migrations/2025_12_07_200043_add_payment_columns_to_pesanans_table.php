<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // 1. HARGA KITA LEWATI (Karena sudah ada di database, biar tidak error duplicate)
            // $table->decimal('harga', 12, 2)->nullable()->after('status');

            // 2. METODE PEMBAYARAN
            // Kita pakai nama 'metode_pembayaran' agar cocok dengan Controller yg saya kasih
            // Isinya nanti: 'Transfer Lunas', 'COD', 'DP', dll.
            $table->string('metode_pembayaran')->nullable()->after('status');

            // 3. BUKTI PEMBAYARAN
            // Kita pakai nama 'bukti_pembayaran' agar cocok dengan Controller
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn(['metode_pembayaran', 'bukti_pembayaran']);

            // Catatan: Jangan drop kolom 'harga' di sini kalau di up() tidak kita buat
        });
    }
};