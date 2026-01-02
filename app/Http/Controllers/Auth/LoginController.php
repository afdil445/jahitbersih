<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // Wajib ada untuk pengecekan role

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani otentikasi pengguna untuk aplikasi dan
    | mengarahkan mereka ke dashboard yang sesuai setelah login.
    |
    */

    use AuthenticatesUsers;

    /**
     * Menentukan arah redirect setelah user berhasil login.
     *
     * @return string
     */
    public function redirectTo()
    {
        // 1. Ambil Role User yang sedang login
        $role = Auth::user()->role;

        // 2. Logika Pengarahan
        if ($role == 'admin') {
            // Jika Admin, arahkan ke Dashboard Admin
            return route('admin.dashboard');
        }

        // Jika Customer (atau role lain), arahkan ke Dashboard Customer
        return route('customer.dashboard');
    }

    /**
     * Membuat instance controller baru.
     *
     * @return void
     */
    public function __construct()
    {
        // User yang sudah login tidak boleh akses halaman login lagi (kecuali untuk logout)
        $this->middleware('guest')->except('logout');
    }
}