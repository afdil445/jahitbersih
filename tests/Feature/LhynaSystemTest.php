<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pesanan;
use App\Models\Portofolio;
use App\Models\Ukuran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LhynaSystemTest extends TestCase
{
    use RefreshDatabase; // Menjamin database bersih di setiap sesi tes

    /** 1. Test Registrasi Berhasil & Hashing (T-01) */
    public function test_registrasi_berhasil_dan_password_terhash()
    {
        $response = $this->post('/register', [
            'name' => 'Ahmad Fadil',
            'email' => 'fadil@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'fadil@example.com']);
        $user = User::where('email', 'fadil@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password)); // Verifikasi Hashing
        $response->assertStatus(302);
    }

    /** 2. Test Login Admin (T-02) */
    public function test_login_admin_mengarahkan_ke_dashboard_admin()
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => Hash::make('admin123')]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }

    /** 3. Test Login Customer (T-03) */
    public function test_login_customer_mengarahkan_ke_dashboard_customer()
    {
        $customer = User::factory()->create(['role' => 'customer', 'password' => Hash::make('user123')]);

        $response = $this->post('/login', [
            'email' => $customer->email,
            'password' => 'user123',
        ]);

        $response->assertRedirect('/customer/dashboard');
    }

    /** 4. Test Proteksi Role (T-04) */
    public function test_customer_tidak_bisa_akses_halaman_admin()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/admin/dashboard');

        $response->assertRedirect('/customer/dashboard');
    }

    /** 5. Test Proteksi Guest (T-05) */
    public function test_guest_tidak_bisa_akses_halaman_buat_pesanan()
    {
        $response = $this->get('/pesanan/buat');

        $response->assertRedirect('/login');
    }

    /** 6. Test Validasi Kosong (T-06) */
    public function test_validasi_form_pesanan_kosong()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->post('/pesanan', []);

        $response->assertSessionHasErrors();
    }

    /** 7. Test Simpan Pesanan (T-07) */
    public function test_customer_bisa_membuat_pesanan()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->post('/pesanan', [
            'user_id' => $customer->id,
            'jenis_pakaian' => 'Kemeja Batik',
            'deskripsi' => 'Ukuran L, slim fit',
            'tipe_layanan' => 'Jahit Baru',
            'status' => 'menunggu',
            'status_pembayaran' => 'belum_bayar',
            'estimasi_selesai' => now()->addDays(7)->format('Y-m-d'),
        ]);

    
        $this->assertDatabaseCount('pesanans', 1);
    }

    /** 8. Test View Admin (T-08) */
    public function test_admin_bisa_melihat_daftar_pesanan()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/pesanan');

        $response->assertStatus(200);
    }

    /** 9. Test Update Status (T-09) */
    public function test_admin_bisa_update_status_pesanan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $pesanan = Pesanan::create([
            'user_id' => $admin->id,
            'jenis_pakaian' => 'Kemeja',
            'tipe_layanan' => 'Jahit Baru',
            'estimasi_selesai' => '2025-12-30',
            'status' => 'menunggu',
            'status_pembayaran' => 'belum_bayar' 
        ]);

        $this->actingAs($admin)->put("/admin/pesanan/{$pesanan->id}", [
            'status' => 'proses',
            'jenis_pakaian' => 'Kemeja',
            'tipe_layanan' => 'Jahit Baru',
            'estimasi_selesai' => '2025-12-30',
            'status_pembayaran' => 'belum_bayar' 
        ]);

        $this->assertDatabaseHas('pesanans', ['id' => $pesanan->id, 'status' => 'proses']);
    }

    /** 10. Test Input Biaya (T-10) */
    public function test_admin_bisa_set_harga_dan_tanggal_selesai()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $pesanan = Pesanan::create([
            'user_id' => $admin->id,
            'jenis_pakaian' => 'Celana',
            'tipe_layanan' => 'Jahit Baru',
            'estimasi_selesai' => '2025-12-30',
            'status' => 'proses',
            'status_pembayaran' => 'belum_bayar'
        ]);

        $this->actingAs($admin)->put("/admin/pesanan/{$pesanan->id}", [
            'harga' => 200000,
            'tgl_selesai' => '2025-12-30',
            'status' => 'proses',
            'jenis_pakaian' => 'Celana',
            'tipe_layanan' => 'Jahit Baru',
            'estimasi_selesai' => '2025-12-30',
            'status_pembayaran' => 'belum_bayar' // WAJIB ADA
        ]);

        $this->assertDatabaseHas('pesanans', ['harga' => 200000]);
    }

    /** 11. Test Tambah Portofolio (T-11) */
    public function test_admin_bisa_tambah_portofolio()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        \Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->image('test.jpg');

        $this->actingAs($admin)->post('/admin/portofolio', [
            'judul' => 'Jas Pria Baru',
            'kategori' => 'Jahit Baru',
            'deskripsi' => 'Deskripsi singkat',
            'gambar' => $file,
        ]);

        $this->assertDatabaseHas('portofolios', ['judul' => 'Jas Pria Baru']);
    }
    /** 12. Test Hapus Portofolio (T-12) */
   public function test_admin_bisa_hapus_portofolio()
{
    $admin = User::factory()->create(['role' => 'admin']);
    $portofolio = Portofolio::create([
        'judul' => 'Hapus Saya',
        'deskripsi' => 'Deskripsi',
        'gambar' => 'test.jpg'
    ]);

    $this->actingAs($admin)->delete("/admin/portofolio/{$portofolio->id}");
    $this->assertDatabaseMissing('portofolios', ['id' => $portofolio->id]);
}

    /** 13. Test Galeri Publik (T-13) */
    public function test_halaman_portofolio_publik_bisa_diakses()
    {
        $response = $this->get('/portofolio');

        $response->assertStatus(200);
    }

    /** 14. Test Update Ukuran (T-14) */
    /** 14. Test Update Ukuran (T-14) */
    public function test_admin_bisa_update_ukuran_badan_pelanggan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        // Mengirim data ke route storeUkuran
        $this->actingAs($admin)->put("/admin/pelanggan/{$customer->id}/ukuran", [
            'telepon' => '08123456789', // Wajib ada sesuai validasi Controller
            'lingkar_dada' => 100,
            'lingkar_pinggang' => 85,
        ]);

        $this->assertDatabaseHas('ukurans', [
            'user_id' => $customer->id,
            'lingkar_dada' => 100
        ]);
    }

    /** 15. Test Validasi Angka (T-15) */
    public function test_validasi_input_ukuran_harus_angka()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        // Tambahkan validasi numeric di Controller jika ingin test ini lulus otomatis
        $response = $this->actingAs($admin)->put("/admin/pelanggan/{$customer->id}/ukuran", [
            'telepon' => '08123456789',
            'lingkar_dada' => 'Bukan Angka'
        ]);

        $response->assertSessionHasErrors(['lingkar_dada']);
    }
}