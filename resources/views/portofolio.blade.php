@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    {{-- JUDUL HALAMAN --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Galeri Hasil Jahitan</h2>
        <p class="text-muted">Koleksi karya terbaik Lhyna Collection spesial untuk pelanggan kami.</p>
    </div>

    {{-- GRID FOTO --}}
    <div class="row g-4">
        @forelse($portofolios as $item)
        <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm border-0 overflow-hidden portofolio-card">
                
                {{-- GAMBAR --}}
                <div class="overflow-hidden position-relative" style="height: 300px;">
                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                         class="card-img-top w-100 h-100 object-fit-cover transition-zoom" 
                         alt="{{ $item->judul }}">
                    
                    {{-- Badge Kategori --}}
                    <span class="position-absolute top-0 start-0 m-3 badge bg-white text-primary shadow-sm px-3 py-2 rounded-pill">
                        {{ $item->kategori }}
                    </span>
                </div>

                {{-- DESKRIPSI --}}
                <div class="card-body text-center p-4">
                    <h5 class="card-title fw-bold text-dark">{{ $item->judul }}</h5>
                    <p class="card-text text-muted small">
                        {{ $item->deskripsi ?? 'Kualitas jahitan premium.' }}
                    </p>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-light rounded-4 p-5">
                <i class="bi bi-images display-1 text-muted opacity-25"></i>
                <h4 class="mt-3 text-muted">Belum ada foto portofolio.</h4>
                <p class="text-muted">Admin belum mengupload foto hasil jahitan terbaru.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- TOMBOL CTA (Call To Action) --}}
    <div class="text-center mt-5">
        <p class="lead mb-3">Tertarik dengan hasil jahitan kami?</p>
        <a href="{{ route('pesanan.create') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
            <i class="bi bi-scissors me-2"></i> Buat Pesanan Sekarang
        </a>
    </div>

</div>

{{-- CSS Tambahan untuk Efek Zoom saat Hover --}}
<style>
    .object-fit-cover {
        object-fit: cover;
    }
    .transition-zoom {
        transition: transform 0.3s ease;
    }
    .portofolio-card:hover .transition-zoom {
        transform: scale(1.05); /* Efek Zoom in sedikit saat mouse nempel */
    }
</style>
@endsection