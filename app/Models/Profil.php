<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_usaha',
        'deskripsi',
        'alamat',
        'email',
        'whatsapp',
        'instagram',
        'maps',
        'foto'
    ];
}