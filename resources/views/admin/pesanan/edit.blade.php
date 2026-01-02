@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-11"> 
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Verifikasi & Update Pesanan</h4>
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="row">
                {{-- BAGIAN KIRI: Form Admin --}}
                <div class="col-md-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white fw-bold">
                            Form Verifikasi Admin
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- 1. Status Pengerjaan --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Status Pengerjaan</label>
                                    <select name="status" class="form-select">
                                        <option value="Menunggu Persetujuan Admin" {{ $pesanan->status == 'Menunggu Persetujuan Admin' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                        <option value="Sedang Dikerjakan" {{ $pesanan->status == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                        <option value="Menunggu Pembayaran" {{ $pesanan->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                        <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai / Siap Diambil</option>
                                        <option value="Dibatalkan" {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>

                                {{-- 2. Status Pembayaran --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Status Pembayaran</label>
                                    <select name="status_pembayaran" class="form-select">
                                        <option value="Belum Dibayar" {{ $pesanan->metode_pembayaran == null ? 'selected' : '' }}>Belum Dibayar</option>
                                        <option value="Menunggu Konfirmasi" {{ $pesanan->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi (Cek Bukti)</option>
                                        <option value="Lunas" {{ $pesanan->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                </div>

                                {{-- 3. Tetapkan Harga --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Tetapkan Harga (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga" class="form-control" 
                                               value="{{ old('harga', $pesanan->harga ?? 0) }}" placeholder="0">
                                    </div>
                                    <div class="form-text small">Masukkan nominal tanpa titik/koma.</div>
                                </div>

                                {{-- 4. Estimasi Selesai (INPUT OTOMATIS) --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Estimasi Selesai / Ambil</label>
                                    {{-- Value diambil dari database estimasi_selesai --}}
                                    <input type="date" name="estimasi_selesai" class="form-control" 
                                           value="{{ old('estimasi_selesai', $pesanan->estimasi_selesai) }}">
                                    <div class="form-text small text-primary">
                                        <i class="bi bi-info-circle"></i> Tanggal ini terisi otomatis dari permintaan pelanggan. Silakan ubah jika perlu.
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success fw-bold">
                                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Bukti Pembayaran --}}
                    @if($pesanan->bukti_pembayaran)
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-header bg-warning text-dark fw-bold">
                            Bukti Pembayaran Pelanggan
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" class="img-fluid rounded thumbnail" style="max-height: 200px">
                            </a>
                            <p class="small text-muted mt-2 mb-0">Klik gambar untuk memperbesar</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- BAGIAN KANAN: Detail Pelanggan --}}
                <div class="col-md-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light fw-bold text-primary">
                            Detail Permintaan Pelanggan
                        </div>
                        <div class="card-body">
                            
                            {{-- Info User --}}
                            <div class="alert alert-info border-0 d-flex align-items-center p-3 mb-4">
                                <div class="me-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-person-fill fs-3 text-info"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Pemesan: {{ $pesanan->user->name ?? 'User Terhapus' }}</h6>
                                    <small class="d-block text-muted">Email: {{ $pesanan->user->email ?? '-' }}</small>
                                </div>
                            </div>

                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="fw-bold" width="30%">Layanan</td>
                                    <td>: <span class="badge bg-primary">{{ $pesanan->tipe_layanan }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jenis Pakaian</td>
                                    <td>: {{ $pesanan->jenis_pakaian }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Masuk</td>
                                    <td>: {{ $pesanan->created_at->format('d M Y, H:i') }} WIB</td>
                                </tr>

                                {{-- BARIS BARU: INI YANG AKAN MUNCUL --}}
                                <tr>
                                    <td class="fw-bold text-danger">Permintaan Selesai</td>
                                    <td>
                                        : 
                                        @if($pesanan->estimasi_selesai)
                                            <span class="badge bg-warning text-dark fs-6">
                                                {{ date('d M Y', strtotime($pesanan->estimasi_selesai)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">- Tidak ada target -</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <hr>
                            
                            <h6 class="fw-bold mt-3">Deskripsi / Catatan:</h6>
                            <div class="p-3 bg-light rounded border mb-3">
                                {!! nl2br(e($pesanan->deskripsi)) !!}
                            </div>

                            {{-- Gambar Referensi (Jika Ada) --}}
                            @if($pesanan->gambar_referensi) 
                            <h6 class="fw-bold">Referensi Model:</h6>
                            <div class="card" style="width: 200px;">
                                 <img src="{{ asset('storage/' . $pesanan->gambar_referensi) }}" class="card-img-top" alt="Referensi">
                                 <div class="card-footer text-center small text-muted">Upload User</div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection