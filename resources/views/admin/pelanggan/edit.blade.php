@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Edit Data Ukuran: {{ $user->name }}</h2>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.pelanggan.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="fw-bold mb-3 text-secondary">Ukuran Tubuh (Masukkan Angka Saja)</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lingkar Leher</label>
                        <div class="input-group">
                            {{-- (int) digunakan untuk menghapus teks 'cm' lama jika ada, agar hanya angka yang muncul --}}
                            <input type="number" name="lingkar_leher" class="form-control" 
                                   value="{{ old('lingkar_leher', (int)$detail->lingkar_leher) }}">
                            <span class="input-group-text bg-light">cm</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lingkar Pinggul</label>
                        <div class="input-group">
                            <input type="number" name="lingkar_pinggul" class="form-control" 
                                   value="{{ old('lingkar_pinggul', (int)$detail->lingkar_pinggul) }}">
                            <span class="input-group-text bg-light">cm</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lingkar Dada</label>
                        <div class="input-group">
                            <input type="number" name="lingkar_dada" class="form-control" 
                                   value="{{ old('lingkar_dada', (int)$detail->lingkar_dada) }}">
                            <span class="input-group-text bg-light">cm</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Panjang Lengan</label>
                        <div class="input-group">
                            <input type="number" name="panjang_lengan" class="form-control" 
                                   value="{{ old('panjang_lengan', (int)$detail->panjang_lengan) }}">
                            <span class="input-group-text bg-light">cm</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lingkar Pinggang</label>
                        <div class="input-group">
                            <input type="number" name="lingkar_pinggang" class="form-control" 
                                   value="{{ old('lingkar_pinggang', (int)$detail->lingkar_pinggang) }}">
                            <span class="input-group-text bg-light">cm</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lebar Bahu</label>
                        <div class="input-group">
                            <input type="number" name="lebar_bahu" class="form-control" 
                                   value="{{ old('lebar_bahu', (int)$detail->lebar_bahu) }}">
                            <span class="input-group-text bg-light">cm</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan Tambahan</label>
                    <textarea name="catatan_ukuran" class="form-control" rows="3" placeholder="Contoh: Bahu agak turun, minta longgar di bagian perut...">{{ old('catatan_ukuran', $detail->catatan_ukuran) }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Simpan Data Ukuran
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection