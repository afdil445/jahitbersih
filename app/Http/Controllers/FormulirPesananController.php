<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio; // Import model Portofolio

class FormulirPesananController extends Controller
{
    public function index()
    {
        // Ambil semua item portofolio yang akan dipajang di form
        $portofolios = Portofolio::all(['id', 'judul']); 

        return view('pesan', compact('portofolios'));
    }
}