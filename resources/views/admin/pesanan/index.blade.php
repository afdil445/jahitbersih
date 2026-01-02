@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Kelola Pesanan</h2>

    <a href="{{ route('admin.pesanan.cetak') }}" target="_blank" class="btn btn-danger shadow-sm">
        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Cetak Laporan PDF
    </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Daftar Pesanan Masuk</h5>
        </div>
        <div class="card-body">
            @if($pesanans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status Pengerjaan</th>
                                <th>Status Pembayaran</th>
                                <th>Harga</th>
                                <th>Tanggal Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanans as $pesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $pesanan->user->name }}</div>
                                    <small class="text-muted">{{ $pesanan->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($pesanan->tipe_layanan) }}</span>
                                    <br>
                                    <small>{{ $pesanan->jenis_pakaian }}</small>
                                </td>
                                <td>
                                    @if($pesanan->status == 'menunggu_persetujuan')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($pesanan->status == 'sedang_dijahit')
                                        <span class="badge bg-primary">Proses Jahit</span>
                                    @elseif($pesanan->status == 'siap_diambil')
                                        <span class="badge bg-info text-dark">Siap Diambil</span>
                                    @elseif($pesanan->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Batal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pesanan->status_pembayaran == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($pesanan->status_pembayaran == 'menunggu_verifikasi')
                                        <span class="badge bg-warning text-dark">Cek Bukti</span>
                                    @else
                                        <span class="badge bg-light text-dark border">Belum Bayar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pesanan->harga)
                                        Rp {{ number_format($pesanan->harga, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ $pesanan->created_at->format('d M Y') }}</td>
                                <td>
                                    {{-- Tombol Edit / Verifikasi --}}
                                    <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i> Proses
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="Empty" width="80" class="mb-3 opacity-50">
                    <p class="text-muted">Belum ada pesanan yang masuk.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection