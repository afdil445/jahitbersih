<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Hitung Total Pesanan (Kotak Biru)
        $totalPesanan = Pesanan::where('user_id', $userId)->count();

        // 2. Hitung Sedang Dikerjakan (Kotak Kuning)
        // (Status selain 'Selesai' dan 'Ditolak' dianggap sedang proses)
        $sedangDikerjakan = Pesanan::where('user_id', $userId)
            ->whereNotIn('status', ['Selesai', 'Ditolak', 'Siap Diambil'])
            ->count();

        // 3. Hitung Siap Diambil / Selesai (Kotak Hijau)
        $siapDiambil = Pesanan::where('user_id', $userId)
            ->where('status', 'Selesai')
            ->count();

        // 4. Ambil 5 Pesanan Terakhir untuk Tabel Bawah
        $pesanans = Pesanan::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('totalPesanan', 'sedangDikerjakan', 'siapDiambil', 'pesanans'));
    }
}