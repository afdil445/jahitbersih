<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kita kembalikan kolom status_pembayaran
            // Kita beri nilai default 'Belum Dibayar' agar tidak error data kosong
            $table->string('status_pembayaran')->nullable()->default('Belum Dibayar')->after('status');

            // Jaga-jaga: Pastikan kolom harga juga ada (karena Admin input harga)
            if (!Schema::hasColumn('pesanans', 'harga')) {
                $table->decimal('harga', 12, 2)->nullable()->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
            // Jangan drop harga, takut data hilang
        });
    }
};