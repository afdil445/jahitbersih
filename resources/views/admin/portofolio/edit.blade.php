@extends('layouts.admin')

@section('title', 'Edit Portofolio')

@section('content')
<div class="container my-5">
    <h1 class="header-title mb-4">Edit Portofolio: {{ $portofolio->judul }}</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card shadow-sm p-4">
        <form action="{{ url('/admin/portofolio/' . $portofolio->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $portofolio->judul) }}" required>
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                @if ($portofolio->gambar)
                    <img src="{{ asset('storage/' . $portofolio->gambar) }}" alt="{{ $portofolio->judul }}" style="max-width: 200px; margin-bottom: 10px;">
                @else
                    <p class="text-muted">Tidak ada gambar tersimpan.</p>
                @endif
                
                <label for="gambar" class="form-label mt-2">Ganti Gambar (Opsional)</label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Perbarui Portofolio</button>
            <a href="{{ url('/admin/portofolio') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection