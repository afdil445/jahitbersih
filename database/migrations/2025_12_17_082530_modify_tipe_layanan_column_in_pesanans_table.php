<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- Jangan lupa ini

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kita paksa ubah kolom tipe_layanan menjadi VARCHAR(255) agar muat teks panjang
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN tipe_layanan VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu diapa-apakan, biarkan saja tetap string panjang
    }
};