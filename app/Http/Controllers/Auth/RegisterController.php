<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani pendaftaran pengguna baru serta validasi
    | dan pembuatannya.
    |
    */

    use RegistersUsers;

    /**
     * Membuat instance controller baru.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Mendapatkan validator untuk permintaan pendaftaran yang masuk.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Membuat data user baru setelah validasi berhasil.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            // PENTING: Kita paksa role-nya jadi 'customer'
            // Supaya user baru tidak punya akses Admin secara tidak sengaja.
            'role' => 'customer',
        ]);
    }

    /**
     * Menentukan arah redirect setelah user selesai mendaftar.
     * * @return string
     */
    public function redirectTo()
    {
        // User baru daftar pasti Customer, langsung arahkan ke Dashboard Customer.
        return route('customer.dashboard');
    }
}