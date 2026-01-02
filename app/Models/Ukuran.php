<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $guarded = []; // Izinkan semua kolom diisi

    public function user()
    {
        return $this->belongsTo(User::class);
        
    }
}

