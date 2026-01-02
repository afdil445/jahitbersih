<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/

// 1. Controller Umum / Publik / Customer
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PesanKontakController;
use App\Http\Controllers\PublicPortofolioController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CustomerPesanController; // PENTING: Untuk fitur 'Pesan Saya'

// 2. Controller Khusus Admin
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminPortofolioController;
use App\Http\Controllers\AdminPesanKontakController;
use App\Http\Controllers\AdminProfilController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ====================================================
// BAGIAN 1: JALUR PUBLIK (BISA DIAKSES SIAPA SAJA)
// ====================================================

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Halaman Kontak Kami (Public Form)
// Menggunakan method 'create' agar sesuai dengan tombol di Navbar
Route::get('/kontak', [PesanKontakController::class, 'create'])->name('kontak.create');
Route::post('/kontak', [PesanKontakController::class, 'store'])->name('kontak.store');

// Halaman Portofolio (Galeri Publik)
Route::get('/portofolio', [PublicPortofolioController::class, 'index'])->name('portofolio.index');


// ====================================================
// BAGIAN 2: OTENTIKASI
// ====================================================
Auth::routes();


// ====================================================
// BAGIAN 3: JALUR KHUSUS CUSTOMER (PELANGGAN)
// ====================================================
Route::middleware(['auth', 'role:customer'])->group(function () {

    // A. Dashboard Customer
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    // B. Riwayat Pesanan
    Route::get('/pesanan/riwayat', [PesananController::class, 'index'])->name('pesanan.index');

    // C. Fitur Buat Pesanan Baru
    Route::get('/pesanan/buat', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

    // D. Fitur Detail & Bayar
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::put('/pesanan/{id}/bayar', [PesananController::class, 'bayar'])->name('pesanan.bayar');

    // E. Pesan Saya (Inbox Customer - Melihat Balasan Admin)
    Route::get('/customer/pesan-saya', [CustomerPesanController::class, 'index'])->name('customer.pesan.index');
});


// ====================================================
// BAGIAN 4: JALUR KHUSUS ADMIN
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // A. Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // B. Kelola Pesanan
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/cetak', [AdminPesananController::class, 'cetakLaporan'])->name('pesanan.cetak'); // Fitur PDF

    // Detail & Edit Pesanan
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id}/edit', [AdminPesananController::class, 'edit'])->name('pesanan.edit');
    Route::put('/pesanan/{id}', [AdminPesananController::class, 'update'])->name('pesanan.update');

    // C. Kelola Pelanggan & Ukuran
    Route::get('/pelanggan', [AdminPelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/{id}/ukuran', [AdminPelangganController::class, 'editUkuran'])->name('pelanggan.ukuran');
    Route::put('/pelanggan/{id}/ukuran', [AdminPelangganController::class, 'storeUkuran'])->name('pelanggan.storeUkuran');

    // D. Kelola Portofolio (CRUD Admin)
    Route::resource('portofolio', AdminPortofolioController::class);

    // E. Inbox Pesan Masuk (Admin Baca & Balas Pesan)
    Route::get('/pesan-kontak', [AdminPesanKontakController::class, 'index'])->name('pesankontak.index');
    Route::post('/pesan-kontak/{id}/reply', [AdminPesanKontakController::class, 'reply'])->name('pesankontak.reply');
    Route::delete('/pesan-kontak/{id}', [AdminPesanKontakController::class, 'destroy'])->name('pesankontak.destroy');

    // F. Profil Usaha
    Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
});

// Redirect Cadangan
Route::get('/home', [HomeController::class, 'index'])->name('home');