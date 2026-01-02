@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    {{-- Bagian Header dengan Sapaan Modern --}}
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #444;">Halo, <span class="text-primary">{{ Auth::user()->name }}!</span></h2>
        <p class="text-muted" style="font-size: 1.1rem;">Selamat datang di dashboard pelanggan Lhyna Collection.</p>
    </div>

    {{-- Bagian 3 Kotak Statistik (Dengan Gradasi Modern) --}}
    <div class="row mb-5 g-4">
        {{-- Kotak 1: Total Pesanan (Gradasi Biru) --}}
        <div class="col-md-4">
            <div class="card bg-gradient-blue text-white h-100 border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75 mb-1">Total Pesanan</h6>
                            <h1 class="display-4 fw-bold mb-0">{{ $totalPesanan }}</h1>
                        </div>
                        <i class="bi bi-bag-check-fill opacity-25" style="font-size: 4rem; position: absolute; right: 20px; bottom: 10px;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kotak 2: Sedang Dikerjakan (Gradasi Kuning) --}}
        <div class="col-md-4">
            <div class="card bg-gradient-yellow text-white h-100 border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75 mb-1">Sedang Dikerjakan</h6>
                            <h1 class="display-4 fw-bold mb-0">{{ $sedangDikerjakan }}</h1>
                        </div>
                        <i class="bi bi-hourglass-split opacity-25" style="font-size: 4rem; position: absolute; right: 20px; bottom: 10px;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kotak 3: Siap Diambil (Gradasi Hijau) --}}
        <div class="col-md-4">
            <div class="card bg-gradient-green text-white h-100 border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75 mb-1">Siap Diambil</h6>
                            <h1 class="display-4 fw-bold mb-0">{{ $siapDiambil }}</h1>
                        </div>
                        <i class="bi bi-check-circle-fill opacity-25" style="font-size: 4rem; position: absolute; right: 20px; bottom: 10px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Tabel: Pesanan Terakhir Anda (Soft UI) --}}
    <div class="card shadow border-0" style="border-radius: 20px;">
        <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f0f0f0; border-radius: 20px 20px 0 0;">
            <h5 class="mb-0 fw-bold text-dark">Pesanan Terakhir Anda</h5>
            <a href="{{ route('pesanan.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary text-uppercase small" style="letter-spacing: 1px;">Tanggal</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small" style="letter-spacing: 1px;">Jenis Pakaian</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small" style="letter-spacing: 1px;">Layanan</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small" style="letter-spacing: 1px;">Status</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small text-end" style="letter-spacing: 1px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $pesanan)
                        <tr>
                            <td class="px-4 fw-bold text-muted">{{ $pesanan->created_at->format('d M Y') }}</td>
                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $pesanan->jenis_pakaian }}</span>
                            </td>
                            <td class="px-4 text-muted">{{ $pesanan->tipe_layanan }}</td>
                            <td class="px-4">
                                @if($pesanan->status == 'Selesai')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Selesai</span>
                                @elseif($pesanan->status == 'Ditolak')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @elseif($pesanan->status == 'Sedang Dikerjakan')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Sedang Dikerjakan</span>
                                @else
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">{{ $pesanan->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 text-end">
                                {{-- Tombol Lihat Detail Modern --}}
                                <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada pesanan terbaru.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    {{-- Footer Copyright --}}
    <div class="text-center mt-5 text-muted small opacity-75">
        &copy; 2025 Lhyna Collection. Digitalisasi Proses Bisnis.
    </div>
</div>
@endsection