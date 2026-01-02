<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pesan_kontaks', function (Blueprint $table) {
            // Mengubah kolom telepon agar boleh kosong (nullable)
            $table->string('telepon')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pesan_kontaks', function (Blueprint $table) {
            $table->string('telepon')->nullable(false)->change();
        });
    }
};
