@extends('layouts.admin')

@section('title', 'Tambah Portofolio')

@section('content')
<div class="container my-5">
    <h1 class="header-title mb-4">Tambah Portofolio Baru</h1>
    
    {{-- Menampilkan Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card shadow-sm p-4">
        <form action="{{ url('/admin/portofolio') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group mb-3">
    <label class="font-weight-bold">Kategori</label>
    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
        <option value="">-- Pilih Kategori --</option>
        <option value="Jahit Kustom">Jahit Kustom</option>
        <option value="Jasa Perbaikan">Jasa Perbaikan</option>
        <option value="Permak">Permak</option>
        <option value="Gaun Pesta">Gaun Pesta</option>
        <option value="Seragam">Seragam</option>
    </select>
    
    @error('kategori')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
            
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Portofolio</label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" required>
                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <button type="submit" class="btn btn-custom-register">Simpan Portofolio</button>
            <a href="{{ url('/admin/portofolio') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection