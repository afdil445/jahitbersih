@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Detail Pesanan #{{ $pesanan->id }}</h3>
        <p class="text-muted mb-0">Informasi lengkap pesanan dari <span class="text-primary fw-bold">{{ $pesanan->user->name ?? $pesanan->nama }}</span>.</p>
    </div>
    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row g-4">
    {{-- KOLOM KIRI: STATUS & INFO UTAMA --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark"><i class="bi bi-info-circle me-2"></i> Status Pesanan</h5>
            </div>
            <div class="card-body p-4">
                
                {{-- Status Pengerjaan --}}
                <div class="mb-3">
                    <small class="text-muted fw-bold text-uppercase">Status Pengerjaan</small>
                    <div class="mt-1">
                        @if($pesanan->status == 'Menunggu')
                            <span class="badge bg-warning text-dark bg-opacity-25 px-3 py-2 rounded-pill">Menunggu</span>
                        @elseif($pesanan->status == 'Diproses')
                            <span class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill">Diproses</span>
                        @elseif($pesanan->status == 'Selesai')
                            <span class="badge bg-success bg-opacity-25 text-success px-3 py-2 rounded-pill">Selesai</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $pesanan->status }}</span>
                        @endif
                    </div>
                </div>

                {{-- Status Pembayaran --}}
                <div class="mb-3">
                    <small class="text-muted fw-bold text-uppercase">Status Pembayaran</small>
                    <div class="mt-1">
                        @if($pesanan->status_pembayaran == 'Lunas')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Lunas</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Belum Dibayar</span>
                        @endif
                    </div>
                </div>

                <hr class="border-light my-4">

                {{-- Harga & Estimasi --}}
                <div class="mb-3">
                    <small class="text-muted fw-bold text-uppercase">Total Harga</small>
                    <h4 class="fw-bold text-primary mt-1">Rp {{ number_format($pesanan->harga ?? 0, 0, ',', '.') }}</h4>
                </div>

                <div class="mb-4">
                    <small class="text-muted fw-bold text-uppercase">Estimasi Selesai</small>
                    <div class="fw-bold text-dark mt-1">
                        <i class="bi bi-calendar-event me-2 text-warning"></i>
                        {{ $pesanan->tgl_estimasi ? \Carbon\Carbon::parse($pesanan->tgl_estimasi)->format('d M Y') : '-' }}
                    </div>
                </div>

                {{-- Tombol Edit --}}
                <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
                    <i class="bi bi-pencil-square me-2"></i> Update Status
                </a>

            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: DETAIL PELANGGAN & PERMINTAAN --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark"><i class="bi bi-person-lines-fill me-2"></i> Data Pelanggan</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Nama Pelanggan</small>
                        <div class="fw-bold text-dark fs-5">{{ $pesanan->user->name ?? $pesanan->nama }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Email</small>
                        <div class="fw-bold text-dark">{{ $pesanan->user->email ?? $pesanan->email }}</div>
                    </div>
                    {{-- Jika ada field telepon di tabel users atau pesanan --}}
                    {{-- <div class="col-md-6 mb-3">
                        <small class="text-muted">No. Telepon</small>
                        <div class="fw-bold text-dark">{{ $pesanan->telepon ?? '-' }}</div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark"><i class="bi bi-scissors me-2"></i> Detail Jahitan</h5>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted w-25">Jenis Layanan</td>
                        <td class="fw-bold text-primary">{{ $pesanan->tipe_layanan }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Pakaian</td>
                        <td class="fw-bold">{{ $pesanan->jenis_pakaian ?? '-' }}</td>
                    </tr>
                    @if($pesanan->pilihan_kain)
                    <tr>
                        <td class="text-muted">Pilihan Kain</td>
                        <td>{{ $pesanan->pilihan_kain }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="text-muted">Catatan / Deskripsi</td>
                        <td>
                            <div class="p-3 bg-light rounded-3 text-secondary border border-dashed">
                                {{ $pesanan->deskripsi ?? 'Tidak ada catatan khusus.' }}
                            </div>
                        </td>
                    </tr>
                </table>

                {{-- Bagian Foto Referensi --}}
                @if($pesanan->gambar_model || $pesanan->gambar_referensi)
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">Lampiran Foto</h6>
                    <div class="row g-3">
                        @if($pesanan->gambar_model)
                        <div class="col-md-4">
                            <div class="rounded-3 overflow-hidden border shadow-sm position-relative group-hover">
                                <img src="{{ asset('storage/' . $pesanan->gambar_model) }}" class="img-fluid" alt="Model">
                                <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white text-center py-1 small">
                                    Referesi Model
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        {{-- Jika Anda menggunakan nama field gambar_referensi untuk kerusakan --}}
                        @if($pesanan->gambar_referensi)
                        <div class="col-md-4">
                            <div class="rounded-3 overflow-hidden border shadow-sm position-relative">
                                <img src="{{ asset('storage/' . $pesanan->gambar_referensi) }}" class="img-fluid" alt="Kerusakan">
                                <div class="position-absolute bottom-0 start-0 w-100 bg-danger bg-opacity-75 text-white text-center py-1 small">
                                    Foto Kerusakan
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection