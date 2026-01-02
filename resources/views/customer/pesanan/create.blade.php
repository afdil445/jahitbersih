@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                {{-- Tombol Kembali --}}
                <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
                </a>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-scissors me-2"></i>Buat Pesanan Jahit Baru
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        {{-- Tampilkan Error Validasi jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- PENTING: enctype="multipart/form-data" wajib ada untuk upload file --}}
                        <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- 1. PILIH LAYANAN --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Mau Pesan Layanan Apa?</label>
                                <select name="tipe_layanan" class="form-select bg-light" required>
                                    <option value="" disabled selected>-- Klik untuk memilih layanan --</option>
                                    <optgroup label="Jahit Baru (Bikin dari Awal)">
                                        <option value="jahit_baru_pria">Pakaian Pria (Kemeja/Celana/Jas)</option>
                                        <option value="jahit_baru_wanita">Pakaian Wanita (Gamis/Kebaya/Dress)</option>
                                        <option value="jahit_seragam">Seragam (Sekolah/Kantor/Komunitas)</option>
                                    </optgroup>
                                    <optgroup label="Perbaikan / Vermak">
                                        <option value="vermak_kecilkan">Kecilkan Ukuran</option>
                                        <option value="vermak_potong">Potong Panjang (Celana/Rok)</option>
                                        <option value="vermak_resleting">Ganti Resleting / Kancing</option>
                                    </optgroup>
                                    <optgroup label="Lainnya">
                                        <option value="pasang_payet">Pasang Payet / Mutiara</option>
                                        <option value="permintaan_khusus">Permintaan Khusus</option>
                                    </optgroup>
                                </select>
                            </div>

                            {{-- 2. JENIS PAKAIAN --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Jenis Pakaian</label>
                                <input type="text" name="jenis_pakaian" class="form-control"
                                    placeholder="Contoh: Kemeja Batik, Gamis Brokat, Celana Jeans" required>
                            </div>

                            <hr class="my-4">

                            {{-- 3. PILIH REFERENSI --}}
                            <h5 class="fw-bold text-secondary mb-3">Referensi Model (Opsional)</h5>

                            {{-- Opsi A: Pilih dari Portofolio --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">A. Pilih Model dari Katalog Portofolio Kami</label>
                                <select name="portofolio_id" class="form-select border-primary">
                                    <option value="">-- Saya punya contoh gambar sendiri (Lihat bawah) --</option>
                                    @if (isset($portofolios) && count($portofolios) > 0)
                                        @foreach ($portofolios as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->judul }} (Kategori: {{ $item->kategori }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="form-text text-primary">
                                    <i class="bi bi-info-circle"></i> Jika memilih ini, Admin akan menjahit sesuai model di katalog.
                                </div>
                            </div>

                            {{-- Opsi B: Upload Sendiri (PENTING: name="gambar_referensi") --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">B. Atau Upload Foto Contoh Sendiri</label>
                                <input type="file" name="gambar_referensi" class="form-control" accept="image/*">
                                <div class="form-text">
                                    Unggah desain dari internet atau foto baju yang Anda inginkan.
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- 4. DESKRIPSI DETAIL --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Catatan Detail / Ukuran</label>
                                <textarea name="deskripsi" class="form-control" rows="5"
                                    placeholder="Misal: Warna merah marun, saku kiri, ukuran XL..." required></textarea>
                            </div>

                            {{-- 5. TANGGAL PENGAMBILAN --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Rencana Diambil Tanggal Berapa?</label>
                                <input type="date" name="estimasi_selesai" class="form-control" required 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('customer.dashboard') }}" class="btn btn-light me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                                    <i class="bi bi-send-fill me-2"></i> Kirim Pesanan Sekarang
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection