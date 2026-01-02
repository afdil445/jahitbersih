<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganDetail extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang dapat diisi secara massal.
     * Ini sesuai dengan kolom-kolom di tabel pelanggan_details.
     */
    protected $fillable = [
        'user_id', 
        'lingkar_leher', 
        'lingkar_dada', 
        'lingkar_pinggang', 
        'lingkar_pinggul', 
        'panjang_lengan', 
        'lebar_bahu', 
        'catatan_ukuran'
    ];

    /**
     * Definisikan relasi: Setiap detail ukuran dimiliki oleh satu pengguna (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}