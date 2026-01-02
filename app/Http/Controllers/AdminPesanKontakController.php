<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesanKontak;
use Illuminate\Support\Facades\Mail; // <--- PENTING: Wajib ada untuk kirim email

class AdminPesanKontakController extends Controller
{
    /**
     * 1. MENAMPILKAN DAFTAR PESAN
     */
    public function index()
    {
        // Ambil pesan terbaru
        $pesans = PesanKontak::latest()->get();
        return view('admin.pesankontak.index', compact('pesans'));
    }

    /**
     * 2. MENGHAPUS PESAN
     */
    public function destroy($id)
    {
        $pesan = PesanKontak::findOrFail($id);
        $pesan->delete();

        return redirect()->route('admin.pesankontak.index')->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * 3. FITUR BALAS PESAN (UPDATE: SIMPAN KE DB & KIRIM EMAIL)
     */
    public function reply(Request $request, $id)
    {
        // A. Validasi Input dari Modal
        $request->validate([
            'subjek' => 'required|string|max:255',
            'pesan_balasan' => 'required|string',
        ]);

        // B. Ambil Data Pesan Asli
        $pesanAsli = PesanKontak::findOrFail($id);

        // ============================================
        // UPDATE BARU: SIMPAN KE DATABASE
        // ============================================
        // Ini agar balasan muncul di dashboard pelanggan
        $pesanAsli->update([
            'balasan' => $request->pesan_balasan
        ]);

        // C. Proses Kirim Email
        try {
            Mail::raw($request->pesan_balasan, function ($message) use ($pesanAsli, $request) {
                $message->to($pesanAsli->email)       // Kirim ke Email Pelanggan
                    ->subject($request->subjek)   // Subjek dari Form
                    ->from(env('MAIL_FROM_ADDRESS'), 'Admin Lhyna Collection'); // Pengirim
            });

            return redirect()->back()->with('success', 'Balasan berhasil disimpan di database & dikirim ke email!');

        } catch (\Exception $e) {
            // Jika email gagal (misal koneksi putus), tapi data sudah tersimpan di database
            return redirect()->back()->with('warning', 'Balasan tersimpan di database, tapi GAGAL kirim email. Cek koneksi internet/SMTP.');
        }
    }
}