@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Riwayat Pesanan Saya</h2>
        <a href="{{ route('pesanan.create') }}" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Buat Pesanan Baru
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Layanan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Pembayaran</th>
                            <th class="px-4 py-3 text-end">Aksi</th> {{-- Kolom Baru --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $key => $pesanan)
                        <tr>
                            <td class="px-4">{{ $key + 1 }}</td>
                            
                            {{-- Tanggal --}}
                            <td class="px-4">
                                {{ $pesanan->created_at->format('d M Y') }}
                                <br>
                                <small class="text-muted">{{ $pesanan->created_at->format('H:i') }} WIB</small>
                            </td>

                            {{-- Layanan & Jenis --}}
                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $pesanan->tipe_layanan }}</span>
                                <br>
                                <span class="small text-muted">{{ $pesanan->jenis_pakaian }}</span>
                            </td>

                            {{-- Status Pesanan --}}
                            <td class="px-4">
                                @if($pesanan->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($pesanan->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($pesanan->status == 'Menunggu Pembayaran')
                                    <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pesanan->status }}</span>
                                @endif
                            </td>

                            {{-- Status Pembayaran --}}
                            <td class="px-4">
                                @if($pesanan->metode_pembayaran)
                                    <span class="badge bg-info text-dark">{{ $pesanan->metode_pembayaran }}</span>
                                @else
                                    <span class="badge bg-light text-muted border">Belum Ada</span>
                                @endif
                            </td>

                            {{-- TOMBOL AKSI (Ini yang sebelumnya hilang) --}}
                            <td class="px-4 text-end">
                                <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn btn-sm btn-primary fw-bold">
                                    Lihat Detail / Bayar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                Belum ada riwayat pesanan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection