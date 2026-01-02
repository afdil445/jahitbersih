<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio; // Pastikan model Portofolio diimpor
use Illuminate\Support\Facades\Storage; // Digunakan untuk manajemen file

class PortofolioController extends Controller
{
    /**
     * Tampilkan daftar portofolio (Read).
     */
    public function index()
    {
        $portofolios = Portofolio::orderBy('created_at', 'desc')->get();
        return view('admin.portofolio.index', compact('portofolios'));
    }

    /**
     * Tampilkan formulir untuk membuat portofolio baru (Create - View).
     */
    public function create()
    {
        return view('admin.portofolio.create');
    }

    /**
     * Simpan portofolio baru ke database (Create - Store).
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // 2. Proses Unggahan Gambar
        $gambarPath = $request->file('gambar')->store('portofolios', 'public');

        // 3. Simpan ke Database
        Portofolio::create([
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
            'gambar' => $gambarPath,
        ]);

        return redirect('/admin/portofolio')->with('success', 'Portofolio berhasil ditambahkan!');
    }

    /**
     * Tampilkan formulir edit portofolio tertentu (Update - View).
     */
    public function edit(Portofolio $portofolio)
    {
        return view('admin.portofolio.edit', compact('portofolio'));
    }

    /**
     * Perbarui portofolio tertentu (Update - Store).
     */
    public function update(Request $request, Portofolio $portofolio)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nullable karena opsional
        ]);

        $data = $validatedData;

        // Proses update gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($portofolio->gambar);
            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('portofolios', 'public');
        }

        $portofolio->update($data);

        return redirect('/admin/portofolio')->with('success', 'Portofolio berhasil diperbarui!');
    }

    /**
     * Hapus portofolio tertentu dari database (Delete).
     */
    public function destroy(Portofolio $portofolio)
    {
        // Hapus file gambar dari storage
        Storage::disk('public')->delete($portofolio->gambar);

        // Hapus entri dari database
        $portofolio->delete();

        return redirect('/admin/portofolio')->with('success', 'Portofolio berhasil dihapus!');
    }
}