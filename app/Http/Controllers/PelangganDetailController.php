<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Penting: Untuk Route Model Binding dan mencari user
use App\Models\PelangganDetail; // Penting: Untuk relasi firstOrCreate dan updateOrCreate

class PelangganDetailController extends Controller
{
    /**
     * Tampilkan daftar pelanggan (index).
     */
    public function index()
    {
        // Ambil semua pengguna dengan peran 'customer'
        $customers = User::where('role', 'customer')->orderBy('name', 'asc')->get();
        return view('admin.pelanggan.index', compact('customers'));
    }

    /**
     * Tampilkan formulir untuk melihat/mengedit detail ukuran pelanggan (edit).
     * @param \App\Models\User $user
     */
    public function edit(User $user)
    {
        // SOLUSI PALING STABIL: Cari Model PelangganDetail secara langsung
        // Menggunakan updateOrCreate untuk memastikan data selalu ada.
        $detail = PelangganDetail::firstOrCreate(
            ['user_id' => $user->id] // Mencari atau membuat berdasarkan ID User
        );
        
        return view('admin.pelanggan.edit', compact('user', 'detail'));
    }

    /**
     * Simpan/perbarui detail ukuran pelanggan (update).
     */
    public function update(Request $request, User $user)
    {
        // Validasi input harus angka (numeric)
        $validatedData = $request->validate([
            'lingkar_leher' => 'nullable|numeric',
            'lingkar_dada' => 'nullable|numeric',
            'lingkar_pinggang' => 'nullable|numeric',
            'lingkar_pinggul' => 'nullable|numeric',
            'panjang_lengan' => 'nullable|numeric',
            'lebar_bahu' => 'nullable|numeric',
            'catatan_ukuran' => 'nullable|string',
        ]);

        // Cari atau buat data detail
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                // Simpan angka saja (Lebih rapi untuk database)
                // Jika Anda ingin di database tertulis '65 cm', ubah jadi: $request->lingkar_leher . ' cm'
                'lingkar_leher' => $request->lingkar_leher,
                'lingkar_dada' => $request->lingkar_dada,
                'lingkar_pinggang' => $request->lingkar_pinggang,
                'lingkar_pinggul' => $request->lingkar_pinggul,
                'panjang_lengan' => $request->panjang_lengan,
                'lebar_bahu' => $request->lebar_bahu,
                'catatan_ukuran' => $request->catatan_ukuran,
            ]
        );

        // 2. Simpan atau perbarui data ke tabel pelanggan_details
        // Laravel akan secara otomatis menggunakan user_id dari relasi.
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $validatedData
        );

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data ukuran pelanggan berhasil diperbarui!');
    }
}