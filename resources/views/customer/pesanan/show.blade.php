@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9"> 
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary mb-3 btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>

            <div class="row">
                {{-- KOLOM KIRI: Detail Pesanan --}}
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 mb-4 h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-receipt me-2"></i>Detail Pesanan #{{ $pesanan->id }}
                            </h5>
                        </div>
                        <div class="card-body">
                            
                            {{-- Status Badge --}}
                            <div class="text-center mb-4">
                                <span class="text-muted small d-block mb-1">Status Saat Ini:</span>
                                @if($pesanan->status == 'Selesai')
                                    <span class="badge bg-success fs-6 px-3 py-2">Selesai</span>
                                @elseif($pesanan->status == 'Ditolak')
                                    <span class="badge bg-danger fs-6 px-3 py-2">Ditolak</span>
                                @else
                                    <span class="badge bg-info text-dark fs-6 px-3 py-2">{{ $pesanan->status }}</span>
                                @endif
                            </div>

                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th class="w-35 text-muted">Tanggal Pesan</th>
                                    <td>: {{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Jenis Pakaian</th>
                                    <td class="fw-bold text-primary">: {{ $pesanan->jenis_pakaian }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Layanan</th>
                                    <td>: {{ $pesanan->tipe_layanan }}</td>
                                </tr>
                                
                                <tr>
                                    <th class="text-muted">Estimasi Selesai</th>
                                    <td>
                                        : 
                                        @if($pesanan->estimasi_selesai)
                                            <span class="badge bg-warning text-dark">{{ date('d M Y', strtotime($pesanan->estimasi_selesai)) }}</span>
                                        @else
                                            <span class="text-muted">- Belum ditentukan -</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-muted">Deskripsi</th>
                                    <td>: {{ $pesanan->deskripsi }}</td>
                                </tr>
                            </table>

                            @if($pesanan->catatan_admin)
                                <div class="alert alert-warning mt-3 p-2 small">
                                    <strong><i class="bi bi-info-circle"></i> Catatan Admin:</strong><br>
                                    {{ $pesanan->catatan_admin }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Pembayaran --}}
                <div class="col-md-5">
                    
                    <div class="card shadow border-0 border-top border-5 border-success mb-3">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-1">Total Biaya</h6>
                            @if($pesanan->harga > 0)
                                <h2 class="fw-bold text-success mb-0">Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</h2>
                                <span class="badge bg-{{ $pesanan->status_pembayaran == 'Lunas' ? 'success' : 'warning' }} mt-2 mb-3">
                                    {{ $pesanan->status_pembayaran ?? 'Belum Dibayar' }}
                                </span>
                            @else
                                <h4 class="fw-bold text-muted mb-3">Rp -</h4>
                                <div class="alert alert-warning small py-1">
                                    Menunggu Harga dari Admin
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- FORMULIR PEMBAYARAN --}}
                    @if($pesanan->harga > 0 && $pesanan->status_pembayaran != 'Lunas' && $pesanan->status != 'Dibatalkan' && $pesanan->status != 'Ditolak')
                        
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white">
                                <i class="bi bi-wallet2"></i> Konfirmasi Pembayaran
                            </div>
                            <div class="card-body">
                                
                                @php $profil = \App\Models\ProfilUsaha::first(); @endphp
                                <div class="alert alert-light border small mb-3" id="rekening_info">
                                    <strong>Transfer ke Bank:</strong><br>
                                    @if($profil && $profil->nomor_rekening)
                                        {{ $profil->nama_bank }} - <b>{{ $profil->nomor_rekening }}</b><br>
                                        A.n {{ $profil->atas_nama }}
                                    @else
                                        BRI - <b>1234-5678-9000</b><br>
                                        A.n Lhyna Collection
                                    @endif
                                </div>

                                <form action="{{ route('pesanan.bayar', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Metode Pembayaran</label>
                                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select form-select-sm" required>
                                            <option value="Transfer Bank">Transfer Bank</option>
                                            <option value="COD">COD (Bayar di Tempat)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="bukti_pembayaran_container">
                                        <label class="form-label small fw-bold">Bukti Transfer (Foto)</label>
                                        {{-- Atribut required dihapus agar tidak error saat pilih COD --}}
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran_input" class="form-control form-control-sm" accept="image/*">
                                        <div class="form-text x-small">Format: JPG/PNG. Maks 2MB.</div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-sm fw-bold">
                                            <i class="bi bi-send"></i> Kirim Konfirmasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @elseif($pesanan->bukti_pembayaran && $pesanan->status_pembayaran != 'Lunas')
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="bi bi-clock-history fs-1 text-info"></i>
                                <h6 class="mt-2">Bukti Terkirim</h6>
                                <p class="small text-muted mb-2">Admin sedang memverifikasi pembayaran Anda.</p>
                                <a href="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    Lihat Bukti Anda
                                </a>
                            </div>
                        </div>

                    @elseif($pesanan->status_pembayaran == 'Lunas')
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="bi bi-check-circle-fill fs-1"></i>
                                <h5 class="mt-2 fw-bold">LUNAS</h5>
                                <p class="small mb-0">Terima kasih atas pembayaran Anda.</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

{{-- JAVASCRIPT UNTUK LOGIKA DINAMIS COD --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectMetode = document.getElementById('metode_pembayaran');
        const containerBukti = document.getElementById('bukti_pembayaran_container');
        const infoRekening = document.getElementById('rekening_info');
        const inputBukti = document.getElementById('bukti_pembayaran_input');

        function toggleInput() {
            if (selectMetode.value === 'COD') {
                containerBukti.style.display = 'none';
                infoRekening.style.display = 'none';
                inputBukti.value = ''; // Kosongkan input file jika user sempat pilih file
            } else {
                containerBukti.style.display = 'block';
                infoRekening.style.display = 'block';
            }
        }

        // Jalankan saat halaman dimuat dan saat dropdown berubah
        selectMetode.addEventListener('change', toggleInput);
        toggleInput(); 
    });
</script>
@endsection