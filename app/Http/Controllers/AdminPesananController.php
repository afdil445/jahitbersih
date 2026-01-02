<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
// 1. PENTING: Import Library PDF
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdminPesananController extends Controller
{
    /**
     * MENAMPILKAN DAFTAR PESANAN
     */
    public function index()
    {
        // Ambil semua pesanan, urutkan dari terbaru
        $pesanans = Pesanan::with('user')->latest()->get();

        // Tampilkan view daftar pesanan
        // Pastikan file view Anda ada di: resources/views/pesanan/list_baru.blade.php
        return view('pesanan.list_baru', compact('pesanans'));
    }

    /**
     * MENAMPILKAN FORM EDIT
     */
    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Pastikan file view ini ada: resources/views/admin/pesanan/edit.blade.php
        return view('admin.pesanan.edit', compact('pesanan'));
    }

    /**
     * MENYIMPAN PERUBAHAN DATA (UPDATE)
     */
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'status' => 'required',
            'harga' => 'nullable|numeric|min:0',
            'status_pembayaran' => 'required',
            'estimasi_selesai' => 'nullable|date',
        ]);

        // 2. Update Data di Database
        $pesanan->update([
            'status' => $request->status,
            'harga' => $request->harga,
            'status_pembayaran' => $request->status_pembayaran,
            'estimasi_selesai' => $request->estimasi_selesai,
        ]);

        // 3. Kembali ke Halaman Daftar
        // Pastikan nama route 'admin.pesanan.index' ada di web.php
        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * FITUR BARU: CETAK LAPORAN PDF (Income Report)
     */
    public function cetakLaporan()
    {
        // 1. Filter Pesanan: Hanya ambil yang statusnya 'selesai' (Uang masuk)
        $pesanans = Pesanan::with('user')
            ->where('status', 'selesai') // Filter penting untuk laporan keuangan
            ->latest()
            ->get();

        // 2. Hitung Total Pendapatan (Sum kolom harga)
        $totalPendapatan = $pesanans->sum('harga');

        // 3. Load View PDF
        // Pastikan file view ini ada: resources/views/admin/pesanan/laporan_pdf.blade.php
        $pdf = Pdf::loadView('admin.pesanan.laporan_pdf', compact('pesanans', 'totalPendapatan'));

        // 4. Download / Stream file PDF
        // 'setPaper' mengatur ukuran kertas A4 Landscape agar tabel muat
        return $pdf->setPaper('a4', 'landscape')->stream('laporan-pendapatan-lhyna.pdf');
    }
}