<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Buat Tabel Ukuran Badan
        Schema::create('ukurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Terhubung ke Pelanggan

            // Data Ukuran Standar Jahit (Dalam CM)
            $table->decimal('lingkar_badan', 5, 2)->nullable();
            $table->integer('lingkar_dada')->nullable();
            $table->decimal('lingkar_pinggang', 5, 2)->nullable();
            $table->decimal('lingkar_panggul', 5, 2)->nullable();
            $table->decimal('lebar_bahu', 5, 2)->nullable();
            $table->decimal('panjang_lengan', 5, 2)->nullable();
            $table->decimal('panjang_baju', 5, 2)->nullable();
            $table->decimal('panjang_celana', 5, 2)->nullable();
            $table->text('catatan_khusus')->nullable(); // Misal: "Bahu miring kiri"

            $table->timestamps();
        });

        // 2. Tambah kolom telepon di tabel Users (jika belum ada)
        if (!Schema::hasColumn('users', 'telepon')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('telepon')->nullable()->after('email');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ukurans');
        if (Schema::hasColumn('users', 'telepon')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('telepon');
            });
        }
    }
};