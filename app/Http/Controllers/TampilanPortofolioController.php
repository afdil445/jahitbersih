<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio; // Impor model Portofolio

class TampilanPortofolioController extends Controller
{
    public function index()
    {
        // Ambil semua data portofolio dari database, diurutkan dari yang terbaru
        $portofolios = Portofolio::orderBy('created_at', 'desc')->get();
        return view('portofolio', compact('portofolios'));
    }
}