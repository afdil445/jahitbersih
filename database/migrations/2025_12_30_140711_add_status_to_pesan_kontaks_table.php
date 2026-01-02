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
            // Menambahkan kolom status dengan nilai default 'belum_dibaca'
            $table->string('status')->default('belum_dibaca')->after('pesan');
        });
    }

    public function down(): void
    {
        Schema::table('pesan_kontaks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
