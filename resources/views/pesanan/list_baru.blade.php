@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">

        {{-- Judul Halaman --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">Kelola Pesanan Masuk</h1>

            {{-- INI TOMBOL BARUNYA --}}
            <a href="{{ route('admin.pesanan.cetak') }}" target="_blank" class="btn btn-secondary shadow-sm">
                <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
            </a>
        </div>
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Pesanan --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 fw-bold">Daftar Semua Pesanan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $index => $pesanan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pesanan->created_at->format('d M Y') }}</td>
                                    <td>
                                        <strong>{{ $pesanan->nama ?? ($pesanan->user->name ?? 'User Terhapus') }}</strong><br>
                                        <small
                                            class="text-muted">{{ $pesanan->email ?? ($pesanan->user->email ?? '-') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $pesanan->tipe_layanan }}</span>
                                        <div class="small text-muted mt-1"
                                            style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $pesanan->jenis_pakaian }}
                                        </div>
                                    </td>

                                    {{-- Status Pembayaran --}}
                                    <td>
                                        @if ($pesanan->status_pembayaran == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @elseif($pesanan->status_pembayaran == 'dp_lunas')
                                            <span class="badge bg-primary">DP Lunas</span>
                                        @elseif($pesanan->status_pembayaran == 'menunggu_verifikasi')
                                            <span class="badge bg-warning text-dark">Cek Bukti</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Bayar</span>
                                        @endif
                                    </td>

                                    {{-- Status Pengerjaan (PERBAIKAN UTAMA DI SINI) --}}
                                    <td>
                                        @if ($pesanan->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($pesanan->status == 'Sedang Dijahit')
                                            <span class="badge bg-info text-dark">Sedang Dijahit</span>
                                        @elseif($pesanan->status == 'Siap Diambil/Dikirim')
                                            <span class="badge bg-primary">Siap Diambil</span>
                                        @elseif($pesanan->status == 'Ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($pesanan->status == 'Menunggu Persetujuan Admin')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @else
                                            {{-- Jika status lain, tampilkan teks aslinya --}}
                                            <span class="badge bg-secondary">{{ $pesanan->status }}</span>
                                        @endif
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td>
                                        {{-- Tombol Detail --}}
                                        <button type="button" class="btn btn-info btn-sm text-white mb-1"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $pesanan->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>

                                        <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}"
                                            class="btn btn-primary btn-sm mb-1">
                                            <i class="bi bi-pencil-square"></i> Update
                                        </a>
                                    </td>
                                </tr>

                                {{-- MODAL POP-UP --}}
                                <div class="modal fade" id="detailModal{{ $pesanan->id }}" tabindex="-1"
                                    aria-labelledby="label{{ $pesanan->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="label{{ $pesanan->id }}">Detail Pesanan
                                                    #{{ $pesanan->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 border-end">
                                                        <h6 class="fw-bold text-primary">Informasi Pelanggan</h6>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Nama:</strong>
                                                                {{ $pesanan->nama ?? $pesanan->user->name }}</li>
                                                            <li><strong>Email:</strong>
                                                                {{ $pesanan->email ?? $pesanan->user->email }}</li>
                                                            <li><strong>Telepon:</strong> {{ $pesanan->telepon ?? '-' }}
                                                            </li>
                                                        </ul>
                                                        <hr>
                                                        <h6 class="fw-bold text-primary">Detail Layanan</h6>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Kategori:</strong> {{ $pesanan->tipe_layanan }}
                                                            </li>
                                                            <li><strong>Jenis:</strong> {{ $pesanan->jenis_pakaian }}</li>
                                                            <li><strong>Estimasi Selesai:</strong>
                                                                {{ $pesanan->estimasi_ambil ? \Carbon\Carbon::parse($pesanan->estimasi_ambil)->format('d M Y') : 'Belum ditentukan' }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-primary">Deskripsi / Request</h6>
                                                        <div class="alert alert-light border">
                                                            {!! nl2br(e($pesanan->deskripsi_pesanan)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($pesanan->gambar_referensi)
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h6 class="fw-bold text-primary">Gambar Referensi</h6>
                                                            <div class="text-center bg-light p-3 border rounded">
                                                                <img src="{{ asset('storage/' . $pesanan->gambar_referensi) }}"
                                                                    class="img-fluid rounded" style="max-height: 300px;"
                                                                    alt="Referensi">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}"
                                                    class="btn btn-primary">Verifikasi Status</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- END MODAL --}}

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4">
                                        <div class="alert alert-warning m-0">Belum ada pesanan masuk.</div>
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
