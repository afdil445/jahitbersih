@extends('layouts.app')

@section('title', 'Buat Pesanan')

@push('styles')
<style>
    /* Konsistensi styling dengan tombol register */
    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
    }
    /* Menyembunyikan bagian formulir secara default */
    .custom-fields, .alteration-fields, #kemejaDetails, #portofolioDetails {
        display: none;
    }
    .card {
        border: none;
    }
</style>
@endpush

@section('content')
<section class="container my-5">
    <h1 class="text-center mb-4 header-title">Formulir Pesanan dan Jasa Perbaikan</h1>
    <p class="text-center lead">Pilih jenis layanan yang Anda butuhkan dan lengkapi detailnya.</p>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm p-4">

                {{-- Menampilkan pesan sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                {{-- Menampilkan error validasi umum --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Permintaan gagal terkirim. Mohon periksa kembali input Anda.
                    </div>
                @endif

                <form action="{{ url('/pesan') }}" method="POST" enctype="multipart/form-data" id="orderForm">
                    @csrf

                    <h4 class="mb-3 header-title">Informasi Pelanggan</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ Auth::user()->name ?? old('nama') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Nomor WhatsApp/HP</label>
                            <input type="tel" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                            @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
    <label for="service_type" class="form-label fw-bold">Pilih Jenis Layanan</label>
    <select class="form-select @error('tipe_layanan') is-invalid @enderror" id="service_type" name="tipe_layanan" required>
        <option value="" selected disabled>-- Pilih Tipe Layanan --</option>
        <option value="Jahit Kustom">Pesanan Baru (Jahit Kustom)</option>
        <option value="Jasa Perbaikan">Jasa Perbaikan/Alterasi</option>
    </select>
    @error('tipe_layanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
                    <div class="mb-4">
                        <label for="estimasi_ambil" class="form-label fw-bold">Estimasi Tanggal Pengambilan (Wajib)</label>
                        <input type="date" class="form-control @error('estimasi_ambil') is-invalid @enderror" id="estimasi_ambil" name="estimasi_ambil" value="{{ old('estimasi_ambil') }}" required>
                        <div class="form-text">Tanggal ini bersifat estimasi, persetujuan Admin diperlukan.</div>
                         @error('estimasi_ambil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div id="customFields" class="custom-fields">
                        <hr>
                        <h4 class="mb-3 header-title">Detail Jahit Kustom</h4>
                        
                        <div class="mb-3">
                            <label for="jenis_pakaian" class="form-label">Jenis Pakaian</label>
                            <select class="form-select" id="jenis_pakaian" name="jenis_pakaian">
                                <option value="">-- Pilih Jenis Pakaian --</option>
                                <option value="Gaun">Gaun Pesta</option>
                                <option value="Kemeja">Kemeja</option>
                                <option value="Celana">Celana</option>
                                <option value="Portofolio_PesanUlang">Pesan Ulang dari Portofolio</option>
                            </select>
                        </div>
                        
                        <div class="mb-3" id="portofolioDetails">
                            <label for="portofolio_id" class="form-label">Pilih Item Portofolio</label>
                            <select class="form-select" id="portofolio_id" name="portofolio_id">
                                <option value="">-- Pilih Portofolio --</option>
                                {{-- Loop data portofolio dari Controller --}}
                                @foreach ($portofolios as $p)
                                    <option value="{{ $p->judul }}">{{ $p->judul }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-success">Opsi ini akan mengisi deskripsi secara otomatis.</div>
                        </div>

                        <div class="mb-3" id="kemejaDetails">
                            <label class="form-label">Detail Kemeja (Kerah, Lengan)</label>
                            <input type="text" class="form-control" name="detail_kemeja" placeholder="Contoh: Kerah tegak, Lengan pendek" value="{{ old('detail_kemeja') }}">
                            <div class="form-text">Isi ini hanya jika jenis pakaian adalah Kemeja.</div>
                        </div>

                        <div class="mb-3">
                            <label for="pilihan_kain" class="form-label">Pilihan Jenis Kain</label>
                            <input type="text" class="form-control" name="pilihan_kain" placeholder="Contoh: Katun, Brokat, Sutra" value="{{ old('pilihan_kain') }}">
                        </div>
                    </div>

                    <div id="alterationFields" class="alteration-fields">
                        <hr>
                        <h4 class="mb-3 header-title">Detail Jasa Perbaikan</h4>
                        <div class="mb-3">
                            <label for="perbaikan_pakaian" class="form-label">Jenis Pakaian yang Diperbaiki</label>
                            <input type="text" class="form-control" name="jenis_pakaian_perbaikan" placeholder="Contoh: Celana Jeans, Gaun Malam" value="{{ old('jenis_pakaian_perbaikan') }}">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_perbaikan" class="form-label">Deskripsi Kerusakan/Alterasi</label>
                            <textarea class="form-control" name="deskripsi_pesanan_perbaikan" rows="3" placeholder="Contoh: Kecilkan pinggang 3cm, tambal robek di lutut">{{ old('deskripsi_pesanan_perbaikan') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto_kerusakan" class="form-label">Unggah Foto Kerusakan (Opsional)</label>
                            <input type="file" class="form-control" name="gambar_referensi">
                        </div>
                    </div>

                    <hr class="mt-4">
                    <h4 class="mb-3 header-title">Deskripsi Tambahan & Foto Contoh</h4>
                    <div class="mb-3">
                        <label for="deskripsi_pesanan_umum" class="form-label">Deskripsi Tambahan (Gaya, Model, Ukuran, dll.)</label>
                        <textarea class="form-control @error('deskripsi_pesanan_umum') is-invalid @enderror" id="deskripsi_pesanan_umum" name="deskripsi_pesanan_umum" rows="4" required>{{ old('deskripsi_pesanan_umum') }}</textarea>
                         @error('deskripsi_pesanan_umum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="foto_contoh" class="form-label">Unggah Foto Contoh Baju (Opsional)</label>
                        <input type="file" class="form-control" name="gambar_contoh">
                    </div>

                    <button type="submit" class="btn btn-submit btn-lg w-100 mt-4">Kirim Permintaan Pesanan</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceType = document.getElementById('service_type');
    const customFields = document.getElementById('customFields');
    const alterationFields = document.getElementById('alterationFields');
    const jenisPakaian = document.getElementById('jenis_pakaian');
    const kemejaDetails = document.getElementById('kemejaDetails');
    const portofolioDetails = document.getElementById('portofolioDetails');
    const portofolioId = document.getElementById('portofolio_id');

    // Fungsi untuk mengatur required pada input
    function setRequired(container, isRequired) {
        container.querySelectorAll('input, select, textarea').forEach(el => {
            if (el.id !== 'portofolio_id' && el.name !== 'detail_kemeja') {
                if (isRequired) {
                    el.setAttribute('required', 'required');
                } else {
                    el.removeAttribute('required');
                }
            }
        });
    }

    // Fungsi utama saat tipe layanan berubah
    serviceType.addEventListener('change', function() {
        const value = this.value;
        
        // Reset semua field
        setRequired(customFields, false);
        setRequired(alterationFields, false);
        customFields.style.display = 'none';
        alterationFields.style.display = 'none';
        kemejaDetails.style.display = 'none';
        portofolioDetails.style.display = 'none';

        if (value === 'Jahit Kustom') {
            customFields.style.display = 'block';
            setRequired(customFields, true);
        } else if (value === 'Jasa Perbaikan') {
            alterationFields.style.display = 'block';
            setRequired(alterationFields, true);
        }
        
        // Hapus required pada deskripsi umum saat mode perbaikan aktif
        // karena deskripsi utama diambil dari field yang berbeda di mode perbaikan
        const deskripsiUmum = document.getElementById('deskripsi_pesanan_umum');
        if (value === 'Jasa Perbaikan') {
             deskripsiUmum.removeAttribute('required');
        } else if (value === 'Jahit Kustom') {
            deskripsiUmum.setAttribute('required', 'required');
        }
    });
    
    // Logika Kondisional untuk Detail Kemeja dan Pesan Ulang Portofolio
    jenisPakaian.addEventListener('change', function() {
        const value = this.value;
        
        // Atur field kemeja
        if (value === 'Kemeja') {
            kemejaDetails.style.display = 'block';
        } else {
            kemejaDetails.style.display = 'none';
        }

        // Atur field Portofolio Pesan Ulang
        if (value === 'Portofolio_PesanUlang') {
            portofolioDetails.style.display = 'block';
            portofolioId.setAttribute('required', 'required');
            // Hapus required pada field jenis pakaian (karena digantikan oleh portofolio_id)
            jenisPakaian.removeAttribute('required');
            
        } else {
            portofolioDetails.style.display = 'none';
            portofolioId.removeAttribute('required');
            jenisPakaian.setAttribute('required', 'required'); // Kembalikan required jika bukan pesan ulang
        }
    });

    // Jalankan event change saat load pertama kali jika ada data lama (old('tipe_layanan'))
    if (serviceType.value) {
        serviceType.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush