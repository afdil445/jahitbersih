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
    Schema::create('pelanggan_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); // Hubungkan 1-ke-1 dengan tabel users

        // Data Ukuran yang Spesifik
        $table->string('lingkar_leher')->nullable();
        $table->string('lingkar_dada')->nullable();
        $table->string('lingkar_pinggang')->nullable();
        $table->string('lingkar_pinggul')->nullable();
        $table->string('panjang_lengan')->nullable();
        $table->string('lebar_bahu')->nullable();
        $table->text('catatan_ukuran')->nullable();

        $table->timestamps();
    });
}
};
