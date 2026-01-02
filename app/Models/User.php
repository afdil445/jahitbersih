<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Import model yang dibutuhkan
use App\Models\Pesanan;
use App\Models\Ukuran;
use App\Models\PelangganDetail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * RELASI UTAMA: Satu pelanggan memiliki banyak pesanan.
     * Ini yang dibutuhkan agar withCount('pesanans') di controller bisa bekerja.
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * RELASI UKURAN: Setiap pengguna memiliki satu baris data ukuran.
     */
    public function ukuran()
    {
        return $this->hasOne(Ukuran::class);
    }

    /**
     * RELASI DETAIL: Hubungkan ke data tambahan pelanggan.
     */
    public function detail()
    {
        return $this->hasOne(PelangganDetail::class, 'user_id');
    }

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telepon', // Tambahkan ini jika Anda mengupdate telepon langsung di model User
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

