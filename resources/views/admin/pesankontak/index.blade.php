@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-0">Kotak Masuk (Pesan Pelanggan)</h3>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert Error (Jika Gagal Kirim Email) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary">Daftar Pesan Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pengirim</th>
                            <th>Pesan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesans as $index => $pesan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><small class="text-muted">{{ $pesan->created_at->format('d M Y, H:i') }}</small></td>
                            <td>
                                <span class="fw-bold d-block">{{ $pesan->nama }}</span>
                                <small class="text-muted">{{ $pesan->email }}</small>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;">{{ $pesan->pesan }}</div>
                                {{-- Tombol Baca Detail --}}
                                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalBaca{{ $pesan->id }}">
                                    Lihat Detail
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    {{-- TOMBOL BALAS (Memicu Modal Balas) --}}
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalBalas{{ $pesan->id }}">
                                        <i class="bi bi-reply-fill"></i> Balas
                                    </button>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('admin.pesankontak.destroy', $pesan->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ms-1">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- MODAL 1: BACA DETAIL PESAN --}}
                        <div class="modal fade" id="modalBaca{{ $pesan->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Detail Pesan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Dari:</strong> {{ $pesan->nama }} ({{ $pesan->email }})</p>
                                        <p><strong>Subjek:</strong> {{ $pesan->subjek ?? '-' }}</p>
                                        <hr>
                                        <div class="bg-light p-3 rounded">{{ $pesan->pesan }}</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL 2: FORM BALAS PESAN (INI YANG BARU) --}}
                        <div class="modal fade" id="modalBalas{{ $pesan->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.pesankontak.reply', $pesan->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-send me-2"></i>Balas Pesan</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- Info Penerima --}}
                                            <div class="mb-3">
                                                <label class="form-label text-muted small fw-bold">Kepada:</label>
                                                <input type="text" class="form-control bg-light" value="{{ $pesan->email }}" readonly>
                                            </div>

                                            {{-- Subjek Balasan --}}
                                            <div class="mb-3">
                                                <label class="form-label text-muted small fw-bold">Subjek:</label>
                                                <input type="text" name="subjek" class="form-control" value="Balasan: {{ $pesan->subjek ?? 'Tanya Jawab Lhyna Collection' }}" required>
                                            </div>

                                            {{-- Isi Balasan --}}
                                            <div class="mb-3">
                                                <label class="form-label text-muted small fw-bold">Isi Balasan:</label>
                                                <textarea name="pesan_balasan" class="form-control" rows="5" required placeholder="Tulis balasan Anda di sini..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-send-fill me-1"></i> Kirim Balasan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pesan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection