<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio;

class PublicPortofolioController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input kategori dari URL (?kategori=...)
        $kategoriTerpilih = $request->query('kategori');

        // 2. Query dasar: Ambil semua portofolio
        $query = Portofolio::query();

        // 3. JIKA ada kategori yang dipilih, filter datanya
        if ($kategoriTerpilih) {
            $query->where('kategori', $kategoriTerpilih);
        }

        // 4. Ambil datanya (terbaru di atas)
        $portofolios = $query->latest()->get();

        // 5. Kirim data ke view
        return view('portofolio.index', compact('portofolios', 'kategoriTerpilih'));
    }
}