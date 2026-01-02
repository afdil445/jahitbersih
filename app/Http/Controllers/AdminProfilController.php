<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilUsaha;

class AdminProfilController extends Controller
{
    public function index()
    {
        // Ambil data pertama, atau buat objek kosong jika belum ada
        $profil = ProfilUsaha::first() ?? new ProfilUsaha();
        return view('admin.profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'email' => 'required|email',
            'alamat' => 'required|string',

            // PENTING: Gunakan nama 'nomor_telepon' dan 'maps_link'
            'nomor_telepon' => 'required|string',
            'maps_link' => 'nullable|string',

            'instagram' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        // 2. Simpan ke Database (Update or Create ID 1)
        ProfilUsaha::updateOrCreate(
            ['id' => 1], // Kunci pencarian
            [
                'nama_usaha' => $request->nama_usaha,
                'email' => $request->email,
                'alamat' => $request->alamat,

                // Pastikan kiri (nama kolom db) dan kanan (nama input form) SAMA
                'nomor_telepon' => $request->nomor_telepon,
                'maps_link' => $request->maps_link,

                'instagram' => $request->instagram,
                'deskripsi' => $request->deskripsi,
            ]
        );

        return redirect()->back()->with('success', 'Profil usaha berhasil diperbarui!');
    }
}