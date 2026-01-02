@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">Verifikasi & Update Pesanan</h1>
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row">
            {{-- KOLOM KIRI: FORMULIR UPDATE ADMIN --}}
            <div class="col-md-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 fw-bold">Form Verifikasi Admin</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Pengerjaan</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">

                                    <option value="menunggu_persetujuan"
                                        {{ $pesanan->status == 'Menunggu Persetujuan Admin' ? 'selected' : '' }}>
                                        Menunggu Persetujuan
                                    </option>

                                    <option value="sedang_dijahit"
                                        {{ $pesanan->status == 'Sedang Dijahit' ? 'selected' : '' }}>
                                        Sedang Dijahit / Proses
                                    </option>

                                    <option value="siap_diambil"
                                        {{ $pesanan->status == 'Siap Diambil/Dikirim' ? 'selected' : '' }}>
                                        Siap Diambil
                                    </option>

                                    <option value="selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>

                                    <option value="dibatalkan" {{ $pesanan->status == 'Ditolak' ? 'selected' : '' }}>
                                        Batalkan Pesanan
                                    </option>

                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 2. Update Status Pembayaran --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Pembayaran</label>
                                <select name="status_pembayaran" class="form-select">
                                    <option value="belum_dibayar"
                                        {{ $pesanan->status_pembayaran == 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar
                                    </option>
                                    <option value="menunggu_verifikasi"
                                        {{ $pesanan->status_pembayaran == 'menunggu_verifikasi' ? 'selected' : '' }}>
                                        Menunggu Verifikasi (Cek Bukti)</option>
                                    <option value="dp_lunas"
                                        {{ $pesanan->status_pembayaran == 'dp_lunas' ? 'selected' : '' }}>DP Lunas</option>
                                    <option value="lunas" {{ $pesanan->status_pembayaran == 'lunas' ? 'selected' : '' }}>
                                        Lunas</option>
                                </select>
                            </div>

                            {{-- 3. Input Harga Final (Admin yang tentukan) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tetapkan Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    {{-- Perhatikan: name="harga" sesuai request controller --}}
                                    <input type="number" name="harga" class="form-control"
                                        value="{{ $pesanan->estimasi_harga ?? ($pesanan->harga ?? 0) }}">
                                </div>
                                <small class="text-muted">Masukkan nominal tanpa titik/koma.</small>
                            </div>

                            {{-- 4. Estimasi Selesai --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estimasi Selesai / Ambil</label>
                                <input type="date" name="estimasi_ambil" class="form-control"
                                    value="{{ $pesanan->estimasi_ambil ? \Carbon\Carbon::parse($pesanan->estimasi_ambil)->format('Y-m-d') : '' }}">
                            </div>

                            <hr>
                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL PESANAN (READ ONLY) --}}
            <div class="col-md-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">Detail Permintaan Pelanggan</h6>
                    </div>
                    <div class="card-body">
                        {{-- Info Pelanggan --}}
                        <div class="alert alert-info">
                            <strong>Pemesan:</strong> {{ $pesanan->nama ?? $pesanan->user->name }} <br>
                            <strong>Email:</strong> {{ $pesanan->email ?? $pesanan->user->email }} <br>
                            <strong>Telepon:</strong> {{ $pesanan->telepon ?? '-' }}
                        </div>

                        {{-- Detail Jahitan --}}
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Layanan</th>
                                <td>: {{ $pesanan->tipe_layanan }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pakaian</th>
                                <td>: {{ $pesanan->jenis_pakaian }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>: {{ $pesanan->created_at->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        </table>

                        <div class="mb-3">
                            <label class="fw-bold">Deskripsi / Catatan:</label>
                            <div class="p-3 bg-light border rounded">
                                {!! nl2br(e($pesanan->deskripsi_pesanan)) !!}
                            </div>
                        </div>

                        {{-- Bukti Pembayaran (Jika Ada) --}}
                        @if ($pesanan->bukti_bayar)
                            <div class="mb-3">
                                <label class="fw-bold text-success">Bukti Pembayaran Masuk:</label>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}" class="img-thumbnail"
                                        style="max-height: 200px">
                                    <br>
                                    <a href="{{ asset('storage/' . $pesanan->bukti_bayar) }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary mt-1">Lihat Full Size</a>
                                </div>
                            </div>
                        @endif

                        {{-- Gambar Referensi (Jika Ada) --}}
                        @if ($pesanan->gambar_referensi)
                            <div class="mb-3">
                                <label class="fw-bold">Gambar Referensi Model:</label>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $pesanan->gambar_referensi) }}" class="img-thumbnail"
                                        style="max-height: 300px">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
