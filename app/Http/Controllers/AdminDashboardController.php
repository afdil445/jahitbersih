<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PesanKontak; // Tetap di-use jika nanti butuh

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. KARTU UNGU: Pesanan Baru (Status 'Menunggu')
        // Menghitung pesanan yang perlu segera diproses
        $pesananBaru = Pesanan::where('status', 'Menunggu')->count();

        // 2. KARTU TEAL: Total Pelanggan
        // Menghitung user dengan role customer
        $totalPelanggan = User::where('role', 'customer')->count();

        // 3. KARTU ORANGE: Pesanan Selesai
        // Menghitung total pesanan yang sudah tuntas
        $pesananSelesai = Pesanan::where('status', 'Selesai')->count();

        // 4. TABEL: Pesanan Terbaru
        // Mengambil 5 data terakhir untuk tabel ringkasan
        $pesananTerbaru = Pesanan::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Kirim variabel ke View 'admin.dashboard'
        return view('admin.dashboard', compact(
            'pesananBaru',
            'totalPelanggan',
            'pesananSelesai',
            'pesananTerbaru'
        ));
    }
}