@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="display-3 fw-bold mb-4" style="color: var(--primary-color);">
                    PILIH PENJAHIT TERBAIK SEMUDAH KLIK!
                </h1>
                
                <p class="fs-4 mb-4 text-dark">
                    Layanan Konsultasi dan Pengukuran GRATIS langsung ke tempat Anda via Website.
                </p>
                
                <h2 class="display-5 fw-bold mt-5 text-dark">
                    PAKAIAN ANDA DIJAMIN PASTI PAS
                </h2>
                
                @guest
                    <a href="{{ route('register') }}" class="btn btn-lg btn-custom-register mt-4">
                        Daftar dan Mulai Pesan Sekarang!
                    </a>
                @else
                    <a href="{{ url('/pesan') }}" class="btn btn-lg btn-custom-register mt-4">
                        Mulai Buat Pesanan Baru!
                    </a>
                @endauth
                
            </div>
        </div>
    </div>
</section>
@endsection