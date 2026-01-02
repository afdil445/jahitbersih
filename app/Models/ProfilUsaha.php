<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilUsaha extends Model
{
    use HasFactory;

    protected $table = 'profil_usahas';

    protected $fillable = [
        'nama_usaha',
        'email',
        'alamat',
        'nomor_telepon', // Pastikan ini ada
        'maps_link',     // Pastikan ini ada
        'instagram',
        'deskripsi',
        'logo', // Jika nanti pakai logo
    ];
}