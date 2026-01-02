@extends('layouts.app')

@section('content')
{{-- 1. ATTENTION: HERO SECTION --}}
<div class="container-fluid px-0 mb-5" style="margin-top: -1.5rem;">
    <div class="position-relative overflow-hidden p-3 p-md-5 text-center bg-white shadow-sm" 
         style="background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), 
                url('https://images.unsplash.com/photo-1556905055-8f358a7a4bb4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'); 
                background-size: cover; background-position: center; border-radius: 0 0 50px 50px;">
        <div class="col-md-8 p-lg-5 mx-auto my-5">
            <h1 class="display-3 fw-bold text-primary mb-3" style="letter-spacing: -1px;">Tampil Percaya Diri dengan Pakaian yang Benar-Benar Pas di Badan!</h1>
            <p class="lead fw-normal text-muted mb-4">Jangan biarkan kain cantikmu rusak karena jahitan yang salah. Di Lhyna Collection, kami mengubah kain impianmu menjadi pakaian eksklusif dengan presisi tinggi.</p>
            <a class="btn btn-primary btn-lg rounded-pill shadow px-5 py-3 fw-bold" href="{{ route('pesanan.create') }}">
                <i class="bi bi-scissors me-2"></i> MULAI BUAT PESANAN SEKARANG
            </a>
        </div>
    </div>
</div>

<div class="container py-5">
    {{-- 2. INTEREST: KEUNGGULAN JASA --}}
    <div class="row text-center mb-5 pt-4">
        <div class="col-12">
            <h6 class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 2px;">Mengapa Memilih Kami?</h6>
            <h2 class="fw-bold mb-4">Kualitas Butik, Harga Terjangkau</h2>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 p-4 border-0 shadow-sm text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 70px;">
                    <i class="bi bi-chat-heart text-primary fs-2"></i>
                </div>
                <h5 class="fw-bold">Konsultasi Desain Gratis</h5>
                <p class="text-muted small">Punya model impian dari internet? Kirim fotonya, dan kita diskusikan agar sesuai dengan bentuk tubuhmu.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 border-0 shadow-sm text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 70px;">
                    <i class="bi bi-gem text-primary fs-2"></i>
                </div>
                <h5 class="fw-bold">Jahitan Halus & Kuat</h5>
                <p class="text-muted small">Setiap tusukan benang diperhatikan dengan detail untuk memastikan pakaian rapi dan tahan lama.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 border-0 shadow-sm text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 70px;">
                    <i class="bi bi-clock-history text-primary fs-2"></i>
                </div>
                <h5 class="fw-bold">Tepat Waktu</h5>
                <p class="text-muted small">Proses produksi dipantau secara digital. Pesananmu selesai tepat sesuai jadwal estimasi.</p>
            </div>
        </div>
    </div>

    {{-- 3. DESIRE: PORTOFOLIO SINGKAT --}}
    <div class="row align-items-center py-5">
        <div class="col-lg-6 mb-4 mb-lg-0 text-center">
            <div class="row g-3">
                <div class="col-6">
                    <img src="https://images.unsplash.com/photo-1594932224828-b4b059bdb996?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded-4 shadow" alt="Tailoring">
                </div>
                <div class="col-6 mt-5">
                    <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded-4 shadow" alt="Sewing">
                </div>
            </div>
        </div>
        <div class="col-lg-6 ps-lg-5 text-center text-lg-start">
            <h2 class="fw-bold mb-4">Wujudkan Mahakarya di Tubuh Anda</h2>
            <p class="text-muted mb-4 lead">Bayangkan hadir di acara spesial dengan gaun atau kemeja yang dibuat khusus hanya untuk Anda. Tidak terlalu longgar, tidak terlalu sempit—hanya kenyamanan dan kemewahan yang sempurna.</p>
            <a href="{{ route('portofolio.index') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Lihat Galeri Hasil Jahitan</a>
        </div>
    </div>

    {{-- 4. ACTION: CALL TO ACTION --}}
    <div class="bg-primary rounded-5 p-5 text-center text-white shadow-lg mt-5 mb-4 bg-gradient-blue" 
         style="background: linear-gradient(135deg, #0d6efd 0%, #4facfe 100%);">
        <h2 class="fw-bold mb-3">Siap Menjadi Pusat Perhatian?</h2>
        <p class="mb-4 opacity-75">Klik tombol di bawah ini untuk mengunggah model pakaianmu dan dapatkan estimasi biaya secara transparan.</p>
        <a href="{{ route('pesanan.create') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow">
            PESAN SEKARANG JUGA
        </a>
    </div>
</div>
@endsection