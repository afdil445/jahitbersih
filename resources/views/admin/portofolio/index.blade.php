@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Portofolio (Galeri)</h1>

    <div class="row">
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 fw-bold">Tambah Foto Baru</h6>
                </div>
                <div class="card-body">
                    {{-- PENTING: enctype="multipart/form-data" WAJIB ADA UNTUK UPLOAD --}}
                    <form action="{{ route('admin.portofolio.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul / Nama Baju</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Kebaya Wisuda Modern" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="Jahit Baru">Jahit Baru</option>
                                <option value="Permak">Permak / Perbaikan</option>
                                <option value="Seragam">Seragam</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Ket: Bahan satin, payet jepang..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Foto</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG. Max 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-upload me-2"></i> Upload Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Daftar Portofolio Saat Ini</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Info</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($portofolios as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->gambar) }}" width="100" class="rounded shadow-sm">
                                    </td>
                                    <td>
                                        <strong>{{ $item->judul }}</strong><br>
                                        <span class="badge bg-info text-dark">{{ $item->kategori }}</span><br>
                                        <small>{{ $item->deskripsi }}</small>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.portofolio.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus foto ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada portofolio diupload.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection