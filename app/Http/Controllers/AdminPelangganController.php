<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ukuran;

class AdminPelangganController extends Controller
{
    // 1. Tampilkan Daftar Pelanggan
    public function index()
    {
        // Ambil user role 'customer' + Hitung jumlah pesanan mereka secara otomatis
        $pelanggans = User::where('role', 'customer')
            ->withCount('pesanans') // Mengambil jumlah data dari tabel pesanan
            ->latest()
            ->get();

        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    // 2. Tampilkan Form Edit Ukuran
    public function editUkuran($id)
    {
        $pelanggan = User::findOrFail($id);

        // Ambil data ukuran jika ada, jika tidak buat instance baru
        $ukuran = Ukuran::firstOrNew(['user_id' => $id]);

        return view('admin.pelanggan.ukuran', compact('pelanggan', 'ukuran'));
    }

    // 3. Simpan Data Ukuran
    // 3. Simpan Data Ukuran
    public function storeUkuran(Request $request, $id)
    {
        $request->validate([
            'telepon' => 'required|string|max:20',
            'lingkar_dada' => 'nullable|numeric', // Tambahkan validasi jika perlu
        ]);

        $pelanggan = User::findOrFail($id);
        $pelanggan->update(['telepon' => $request->telepon]);

        Ukuran::updateOrCreate(
            ['user_id' => $id],
            [
                'lingkar_badan' => $request->lingkar_badan,
                'lingkar_dada' => $request->lingkar_dada, // WAJIB DITAMBAHKAN DI SINI
                'lingkar_pinggang' => $request->lingkar_pinggang,
                'lingkar_panggul' => $request->lingkar_panggul,
                'lebar_bahu' => $request->lebar_bahu,
                'panjang_lengan' => $request->panjang_lengan,
                'panjang_baju' => $request->panjang_baju,
                'panjang_celana' => $request->panjang_celana,
                'catatan_khusus' => $request->catatan_khusus,
            ]
        );

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data ukuran pelanggan berhasil disimpan!');
    }
}