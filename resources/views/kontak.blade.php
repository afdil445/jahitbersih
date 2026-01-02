@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Hubungi Kami & Kunjungi Lokasi</h2>
        <p class="text-muted">Kami siap melayani kebutuhan jahit Anda dengan sepenuh hati.</p>
    </div>

    <div class="row g-4">
        {{-- BAGIAN KIRI: Info Kontak --}}
        <div class="col-md-5">
            <div class="card bg-primary text-white h-100 shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4"><i class="bi bi-info-circle me-2"></i>Informasi Kontak</h4>
                    
                    {{-- 1. NAMA USAHA --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-light opacity-75 small text-uppercase">Nama Usaha</h6>
                        <p class="fs-5 fw-bold mb-0">{{ $profil->nama_usaha ?? 'Lhyna Collection' }}</p>
                    </div>

                    {{-- 2. ALAMAT --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-light opacity-75 small text-uppercase"><i class="bi bi-geo-alt-fill me-2"></i>Alamat</h6>
                        <p class="mb-0">{{ $profil->alamat ?? 'Alamat belum diatur.' }}</p>
                    </div>

                    {{-- 3. NOMOR TELEPON (PENTING: Pakai 'nomor_telepon' bukan 'whatsapp') --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-light opacity-75 small text-uppercase"><i class="bi bi-whatsapp me-2"></i>WhatsApp / Telepon</h6>
                        <p class="mb-0">{{ $profil->nomor_telepon ?? '-' }}</p>
                    </div>

                    {{-- 4. EMAIL --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-light opacity-75 small text-uppercase"><i class="bi bi-envelope-fill me-2"></i>Email</h6>
                        <p class="mb-0">{{ $profil->email ?? '-' }}</p>
                    </div>

                    {{-- 5. INSTAGRAM (Baru Ditambahkan) --}}
                    @if(!empty($profil->instagram))
                    <div class="mb-4">
                        <h6 class="fw-bold text-light opacity-75 small text-uppercase"><i class="bi bi-instagram me-2"></i>Instagram</h6>
                        <p class="mb-0">{{ $profil->instagram }}</p>
                    </div>
                    @endif
                    
                    {{-- 6. DESKRIPSI --}}
                    <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                         <p class="small fst-italic mb-0">"{{ $profil->deskripsi ?? '' }}"</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: Form (Biarkan tetap sama) --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary mb-4">Kirim Pesan Cepat</h4>
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('kontak.store') }}" method="POST">
                        @csrf
                        @guest
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">Nama Anda</label>
                                <input type="text" name="nama_tamu" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">Email Anda</label>
                                <input type="email" name="email_tamu" class="form-control" required>
                            </div>
                        </div>
                        @endguest
                        
                        <div class="mb-3">
                            <label class="form-label small">Subjek</label>
                            <input type="text" name="subjek" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Pesan</label>
                            <textarea name="pesan" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: GOOGLE MAPS --}}
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold text-primary mb-3"><i class="bi bi-map-fill me-2"></i>Lokasi Kami</h4>
            <div class="card shadow-sm border-0 overflow-hidden rounded-4">
                {{-- PENTING: Gunakan 'maps_link' --}}
                @if(!empty($profil->maps_link))
                    <div class="ratio ratio-21x9">
                        {{-- Logika: Jika link penuh (iframe) tampilkan langsung. Jika cuma link pendek, bungkus iframe --}}
                        @if(str_contains($profil->maps_link, '<iframe'))
                            {!! $profil->maps_link !!}
                        @else
                            <iframe src="{{ $profil->maps_link }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        @endif
                    </div>
                @else
                    <div class="bg-light text-center py-5">
                        <p class="text-muted">Peta lokasi belum diatur oleh Admin.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection