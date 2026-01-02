@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Data Pelanggan</h3>
        <p class="text-muted mb-0">Kelola informasi pelanggan dan riwayat ukuran baju mereka.</p>
    </div>
</div>

{{-- Pesan Sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small">No</th>
                        <th class="py-3 text-uppercase small">Pelanggan</th>
                        <th class="py-3 text-uppercase small">Kontak</th>
                        <th class="py-3 text-uppercase small">Total Pesanan</th>
                        <th class="pe-4 py-3 text-uppercase small text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $index => $user)
                    <tr>
                        <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" 
                                     class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <small class="text-muted">ID: #CUST-{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-dark"><i class="bi bi-envelope me-1 text-primary"></i> {{ $user->email }}</div>
                            <div class="small text-muted"><i class="bi bi-whatsapp me-1 text-success"></i> {{ $user->phone ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                {{ $user->pesanans_count ?? 0 }} Pesanan
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            {{-- Tombol Kelola Ukuran --}}
                            <a href="{{ route('admin.pelanggan.ukuran', $user->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-rulers me-1"></i> Kelola Ukuran
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted opacity-50">
                                <i class="bi bi-people display-4 mb-3 d-block"></i>
                                <p>Belum ada data pelanggan terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection