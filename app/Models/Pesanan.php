<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * PENTING: Daftarkan semua nama kolom database di sini
     * agar Laravel mengizinkan penyimpanan data (Mass Assignment).
     */
    protected $fillable = [
        'user_id',
        'jenis_pakaian',
        'tipe_layanan',
        'deskripsi',
        'estimasi_selesai',
        'status',
        'status_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'harga' // TAMBAHKAN kolom ini jika belum ada
    ];

    /**
     * Relasi ke model User (Pelanggan).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}