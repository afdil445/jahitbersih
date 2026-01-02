@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Ringkasan Bisnis</h3>
    <p class="text-muted">Pantau perkembangan Lhyna Collection hari ini.</p>
</div>

{{-- 1. KARTU STATISTIK --}}
<div class="row g-4 mb-5">
    
    {{-- Kartu Pesanan Baru (Ungu) --}}
    <div class="col-md-4">
        <div class="card bg-gradient-purple text-white h-100 border-0 shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase opacity-75 small fw-bold">Pesanan Baru</h6>
                        {{-- Pastikan controller mengirim variabel ini, atau ganti dengan angka dummy dulu --}}
                        <h2 class="display-5 fw-bold mb-0">{{ $pesananBaru ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-bag-plus opacity-25" style="font-size: 3.5rem;"></i>
                </div>
                <div class="mt-3 small opacity-75">
                    <i class="bi bi-arrow-up-circle"></i> Perlu diproses segera
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Pelanggan (Teal) --}}
    <div class="col-md-4">
        <div class="card bg-gradient-teal text-white h-100 border-0 shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase opacity-75 small fw-bold">Total Pelanggan</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalPelanggan ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-people-fill opacity-25" style="font-size: 3.5rem;"></i>
                </div>
                <div class="mt-3 small opacity-75">
                    <i class="bi bi-check-circle"></i> Pelanggan terdaftar aktif
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Pendapatan/Selesai (Orange) --}}
    <div class="col-md-4">
        <div class="card bg-gradient-orange text-white h-100 border-0 shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase opacity-75 small fw-bold">Pesanan Selesai</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $pesananSelesai ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-trophy-fill opacity-25" style="font-size: 3.5rem;"></i>
                </div>
                <div class="mt-3 small opacity-75">
                    <i class="bi bi-star-fill"></i> Total jahitan tuntas
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. TABEL RINGKASAN TERBARU --}}
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Pesanan Masuk Terbaru</h5>
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Pelanggan</th>
                                <th>Jenis Pakaian</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananTerbaru as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $p->user->name ?? 'Tamu' }}</div>
                                    <div class="small text-muted">{{ $p->user->email ?? '-' }}</div>
                                </td>
                                <td>{{ $p->jenis_pakaian }}</td>
                                <td class="text-muted small">{{ $p->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($p->status == 'Menunggu')
                                        <span class="badge bg-warning text-dark bg-opacity-25 px-3 py-2 rounded-pill">Menunggu</span>
                                    @elseif($p->status == 'Diproses')
                                        <span class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill">Diproses</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $p->status }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.pesanan.edit', $p->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Proses
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan masuk hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection