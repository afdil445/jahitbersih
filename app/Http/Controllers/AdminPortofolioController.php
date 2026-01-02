<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio; // Pastikan Model Portofolio Ada
use Illuminate\Support\Facades\Storage;

class AdminPortofolioController extends Controller
{
    // 1. TAMPILKAN DAFTAR & FORM
    public function index()
    {
        $portofolios = Portofolio::latest()->get();
        // Pastikan view ini kita buat di Langkah 3
        return view('admin.portofolio.index', compact('portofolios'));
    }

    // 2. SIMPAN DATA & GAMBAR
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Upload Gambar
        // Gambar akan disimpan di folder: storage/app/public/portofolios
        $path = $request->file('gambar')->store('portofolios', 'public');

        Portofolio::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'gambar' => $path,
        ]);

        return redirect()->back()->with('success', 'Portofolio berhasil ditambahkan!');
    }

    // 3. HAPUS DATA
    public function destroy($id)
    {
        $item = Portofolio::findOrFail($id);

        // Hapus file gambar fisik dari penyimpanan agar tidak menuh-menuhin server
        if ($item->gambar) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}