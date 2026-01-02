<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    /**
     * 1. MENAMPILKAN RIWAYAT PESANAN
     */
    public function index()
    {
        // Ambil pesanan milik user yang sedang login, urutkan dari yang terbaru
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.pesanan.index', compact('pesanans'));
    }

    /**
     * 2. MENAMPILKAN FORM BUAT PESANAN
     */
    public function create()
    {
        // Ambil data portofolio untuk dropdown
        $portofolios = Portofolio::all();

        return view('customer.pesanan.create', compact('portofolios'));
    }

    /**
     * 3. MENYIMPAN PESANAN BARU (DIPERBARUI DENGAN FITUR UPLOAD)
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'jenis_pakaian' => 'required',
            'tipe_layanan' => 'required',
            'deskripsi' => 'required',
            'estimasi_selesai' => 'required|date|after:today',
            // Tambahkan validasi untuk file gambar referensi
            'gambar_referensi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'estimasi_selesai.after' => 'Tanggal pengambilan minimal besok, tidak boleh hari ini atau tanggal lampau.'
        ]);

        // A. Logika Menggabungkan Deskripsi dengan Pilihan Portofolio
        $deskripsiFinal = $request->deskripsi;
        if ($request->has('portofolio_id') && $request->portofolio_id != null) {
            $porto = Portofolio::find($request->portofolio_id);
            if ($porto) {
                $deskripsiFinal = "REFERENSI MODEL: " . $porto->judul . " (Kategori: " . $porto->kategori . ")\n\n" . $request->deskripsi;
            }
        }

        // B. Logika Upload Gambar Referensi (Jika ada file yang diunggah)
        $pathGambar = null;
        if ($request->hasFile('gambar_referensi')) {
            // File akan disimpan di: storage/app/public/referensi-pesanan
            $pathGambar = $request->file('gambar_referensi')->store('referensi-pesanan', 'public');
        }

        // C. Simpan data ke Database
        Pesanan::create([
            'user_id' => Auth::id(),
            'jenis_pakaian' => $request->jenis_pakaian,
            'tipe_layanan' => $request->tipe_layanan,
            'deskripsi' => $deskripsiFinal,
            'estimasi_selesai' => $request->estimasi_selesai,
            'status' => 'Menunggu Persetujuan Admin',
            'status_pembayaran' => 'Belum Dibayar',
            'gambar_referensi' => $pathGambar, // Menyimpan jalur file ke database
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat! Menunggu persetujuan admin.');
    }

    /**
     * 4. MENAMPILKAN DETAIL PESANAN
     */
    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Keamanan: Pastikan yang lihat adalah pemiliknya
        if ($pesanan->user_id != Auth::id()) {
            abort(403, 'Anda tidak berhak melihat pesanan ini.');
        }

        return view('customer.pesanan.show', compact('pesanan'));
    }

    /**
     * 5. PROSES PEMBAYARAN
     */
    public function bayar(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([
            'metode_pembayaran' => 'required',
            'bukti_pembayaran' => 'nullable|required_if:metode_pembayaran,Transfer Bank|image|max:2048',
        ]);

        // Update data: Kita ubah status pengerjaan juga agar Admin melihat perubahan
        $data = [
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'Menunggu Verifikasi',
            'status' => ($request->metode_pembayaran == 'COD') ? 'Menunggu Konfirmasi COD' : 'Menunggu Verifikasi Pembayaran',
        ];

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti-bayar', 'public');
            $data['bukti_pembayaran'] = $path;
        }

        $pesanan->update($data); // Data akan tersimpan jika kolom sudah masuk $fillable

        return redirect()->back()->with('success', 'Konfirmasi pembayaran berhasil dikirim!');
    }
}