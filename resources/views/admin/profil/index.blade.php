@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Profil Usaha</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kelola Identitas Bisnis</h6>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- NAMA USAHA --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control" 
                                   value="{{ old('nama_usaha', $profil->nama_usaha) }}" required>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Bisnis</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ old('email', $profil->email) }}" required>
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $profil->alamat) }}</textarea>
                        </div>

                        {{-- NOMOR TELEPON / WHATSAPP (PERHATIKAN NAME-NYA!) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp / Telepon</label>
                            {{-- PENTING: name harus 'nomor_telepon', BUKAN 'whatsapp' --}}
                            <input type="text" name="nomor_telepon" class="form-control" 
                                   placeholder="Contoh: 081234567890"
                                   value="{{ old('nomor_telepon', $profil->nomor_telepon) }}">
                        </div>

                        {{-- INSTAGRAM --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Instagram (Opsional)</label>
                            <input type="text" name="instagram" class="form-control" 
                                   value="{{ old('instagram', $profil->instagram) }}">
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Usaha</label>
                            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                        </div>

                        {{-- GOOGLE MAPS (PERHATIKAN NAME-NYA!) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Embed Google Maps</label>
                            {{-- PENTING: name harus 'maps_link', BUKAN 'maps' --}}
                            <textarea name="maps_link" class="form-control" rows="3" 
                                      placeholder="Masukkan kode <iframe...> dari Google Maps">{{ old('maps_link', $profil->maps_link) }}</textarea>
                            <small class="text-muted">Cara ambil: Buka Google Maps > Share > Embed a map > Copy HTML.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-save me-2"></i> SIMPAN PERUBAHAN
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection