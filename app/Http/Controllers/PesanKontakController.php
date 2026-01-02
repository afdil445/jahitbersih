<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesanKontak;
use App\Models\ProfilUsaha; // Pastikan Model ProfilUsaha dipanggil

class PesanKontakController extends Controller
{
    // 1. MENAMPILKAN HALAMAN KONTAK (CUSTOMER)
    public function create()
    {
        // Ambil data profil usaha (Baris pertama/ID 1)
        $profil = ProfilUsaha::first();

        // JAGA-JAGA: Jika Admin belum pernah isi profil, kita buat data kosong biar tidak error
        if (!$profil) {
            $profil = new ProfilUsaha();
            $profil->nama_usaha = 'Lhyna Collection';
            $profil->alamat = 'Alamat belum diatur admin';
            $profil->email = 'admin@lhyna.com';
            $profil->nomor_telepon = '-';
            $profil->maps_link = '';
        }

        return view('kontak', compact('profil'));
    }

    // ... (Function store dan index di bawahnya biarkan saja) ...
    public function store(Request $request)
    {
        // ... (Biarkan kode store Anda yang lama) ...
        // Kode ini tidak perlu diubah jika kirim pesan sudah berhasil
        $request->validate([
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        PesanKontak::create([
            'user_id' => auth()->id(),
            'nama' => auth()->check() ? auth()->user()->name : $request->nama_tamu,
            'email' => auth()->check() ? auth()->user()->email : $request->email_tamu,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
            'status' => 'belum_dibaca',
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function index()
    {
        $pesans = PesanKontak::latest()->get();
        return view('admin.pesankontak.index', compact('pesans'));
    }
}