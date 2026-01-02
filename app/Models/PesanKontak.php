<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanKontak extends Model
{
    use HasFactory;
    
    // Ini kuncinya: Izinkan semua data masuk (Jurus Anti-Ribet)
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'subjek', // Pastikan kolom ini sudah ditambahkan
        'pesan',
        'status',
        'telepon',
    ];
}