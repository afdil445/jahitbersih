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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Pelanggan yang pesan

            // Data Kontak
            $table->string('nama');
            $table->string('email');
            $table->string('telepon');

            // Detail Pesanan
            $table->string('tipe_layanan');
            $table->string('jenis_pakaian')->nullable(); // Gaun, Kemeja, Celana, dll.
            $table->text('deskripsi_pesanan'); // Deskripsi dari pelanggan
            $table->string('pilihan_kain')->nullable(); // Jenis kain yang diinginkan
            $table->string('detail_kemeja')->nullable(); // (Ex: Kerah tegak, Lengan pendek)
            
            // Kolom Gambar
            $table->string('gambar_contoh')->nullable(); // Foto contoh baju/motif
            $table->string('gambar_referensi')->nullable(); // Foto kerusakan/referensi

            // Admin & Status
            $table->string('status')->default('Menunggu Persetujuan Admin');
            $table->string('status_pembayaran')->default('DP'); // Contoh: DP, Lunas
            $table->decimal('estimasi_harga', 10, 2)->nullable(); // Estimasi Harga dari Admin
            $table->date('estimasi_ambil'); // Estimasi tanggal ambil dari pelanggan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};