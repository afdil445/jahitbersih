@extends('layouts.app')

@section('content')
{{-- KITA TARUH CSS DI SINI LANGSUNG AGAR PASTI TERBACA --}}
<style>
    /* 1. Paksa Grid 3 Kolom */
    .portfolio-grid {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    /* 2. Paksa Ukuran Kotak (1:1) */
    .portfolio-card-box {
        width: 100%;
        aspect-ratio: 1 / 1 !important; /* WAJIB KOTAK */
        overflow: hidden;
        background-color: #f0f0f0;
        position: relative;
    }

    .portfolio-card-box img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important; /* Agar gambar memenuhi kotak */
        transition: 0.4s;
    }

    .card:hover .portfolio-card-box img {
        transform: scale(1.1);
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Galeri Portofolio</h2>
        <p class="text-muted">Koleksi hasil jahitan Lhyna Collection</p>

        {{-- Filter --}}
        <div class="mt-4">
            <a href="{{ route('portofolio.index') }}" class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">SEMUA</a>
            <a href="{{ route('portofolio.index', ['kategori' => 'Jahit Baru']) }}" class="btn btn-sm {{ request('kategori') == 'Jahit Baru' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Jahit Baru</a>
            <a href="{{ route('portofolio.index', ['kategori' => 'Vermak']) }}" class="btn btn-sm {{ request('kategori') == 'Vermak' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Vermak</a>
            <a href="{{ route('portofolio.index', ['kategori' => 'Lainnya']) }}" class="btn btn-sm {{ request('kategori') == 'Lainnya' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">Lainnya</a>
        </div>
    </div>

    <div class="row g-4">
        @forelse($portofolios as $item)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-4">
                    
                    {{-- AREA KOTAK --}}
                    <div class="portfolio-card-box">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                    </div>

                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-1">{{ $item->judul }}</h6>
                        <p class="text-muted small mb-0">{{ Str::limit($item->deskripsi, 40) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Data kosong.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection