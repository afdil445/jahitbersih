@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Kelola Ukuran Pelanggan</h3>
        <p class="text-muted mb-0">Detail ukuran badan untuk: <span class="text-primary fw-bold">{{ $pelanggan->name }}</span></p>
    </div>
    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.pelanggan.storeUkuran', $pelanggan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- KOLOM KIRI: INFO KONTAK & CATATAN --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pelanggan->name) }}&background=0d6efd&color=fff&size=100" class="rounded-circle shadow-sm mb-3">
                    <h5 class="fw-bold mb-1">{{ $pelanggan->name }}</h5>
                    <p class="text-muted small mb-4">{{ $pelanggan->email }}</p>
                    
                    <div class="text-start">
                        <label class="form-label small fw-bold text-muted text-uppercase">No. Telepon / WhatsApp</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-whatsapp"></i></span>
                            <input type="text" name="telepon" class="form-control bg-light border-0" value="{{ $pelanggan->telepon }}" placeholder="Contoh: 0812345678">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">Catatan Khusus</label>
                    <textarea name="catatan_khusus" class="form-control bg-light border-0" rows="5" placeholder="Contoh: Bahu sedikit miring ke kiri, suka pakaian agak longgar.">{{ $ukuran->catatan_khusus }}</textarea>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM UKURAN --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark"><i class="bi bi-rulers me-2"></i> Detail Ukuran (cm)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Lingkar Badan</label>
                            <input type="number" step="0.1" name="lingkar_badan" class="form-control bg-light border-0" value="{{ $ukuran->lingkar_badan }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Lingkar Pinggang</label>
                            <input type="number" step="0.1" name="lingkar_pinggang" class="form-control bg-light border-0" value="{{ $ukuran->lingkar_pinggang }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Lingkar Panggul</label>
                            <input type="number" step="0.1" name="lingkar_panggul" class="form-control bg-light border-0" value="{{ $ukuran->lingkar_panggul }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Lebar Bahu</label>
                            <input type="number" step="0.1" name="lebar_bahu" class="form-control bg-light border-0" value="{{ $ukuran->lebar_bahu }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Panjang Lengan</label>
                            <input type="number" step="0.1" name="panjang_lengan" class="form-control bg-light border-0" value="{{ $ukuran->panjang_lengan }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Panjang Baju</label>
                            <input type="number" step="0.1" name="panjang_baju" class="form-control bg-light border-0" value="{{ $ukuran->panjang_baju }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted fw-bold text-uppercase">Panjang Celana / Rok</label>
                            <input type="number" step="0.1" name="panjang_celana" class="form-control bg-light border-0" value="{{ $ukuran->panjang_celana }}">
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow">
                            <i class="bi bi-save me-2"></i> SIMPAN UKURAN PELANGGAN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection