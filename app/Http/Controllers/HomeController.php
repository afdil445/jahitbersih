<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * POS SATPAM OTOMATIS
     * Fungsi ini akan dijalankan setiap kali User selesai Login atau Register.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Jika Bos (Admin) -> Masuk Dashboard Admin
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 2. Jika Pelanggan (Customer) -> Masuk Dashboard Customer
        if ($user->role == 'customer') {
            return redirect()->route('customer.dashboard');
        }

        // 3. Jika tidak punya role, baru tampilkan halaman biasa
        return view('home');
    }
}