<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // 1. Hapus kolom yang BIKIN ERROR (Wajib isi tapi tidak kita pakai)
            if (Schema::hasColumn('pesanans', 'estimasi_ambil')) {
                $table->dropColumn('estimasi_ambil');
            }
            if (Schema::hasColumn('pesanans', 'status_pembayaran')) {
                $table->dropColumn('status_pembayaran');
            }

            // 2. Hapus kolom SAMPAH (Dobel/Tidak terpakai)
            $columnsXd = ['pilihan_kain', 'detail_kemeja', 'gambar_contoh', 'bukti_bayar', 'estimasi_harga'];

            foreach ($columnsXd as $col) {
                if (Schema::hasColumn('pesanans', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu diisi, kita move on
    }
};