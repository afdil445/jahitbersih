<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesanKontak; // Pastikan Model PesanKontak ada
use Illuminate\Support\Facades\Auth;

class CustomerPesanController extends Controller
{
    public function index()
    {
        // Ambil pesan HANYA milik user yang sedang login
        // Urutkan dari yang terbaru
        $pesanans = PesanKontak::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.pesan.index', compact('pesanans'));
    }
}