<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kita tambahkan kolom deskripsi
            // Kita taruh setelah tipe_layanan biar rapi
            $table->text('deskripsi')->nullable()->after('tipe_layanan');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};