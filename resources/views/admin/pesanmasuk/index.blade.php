@extends('layouts.admin')
@section('title', 'Kotak Masuk Pesan')

@section('content')
<div class="container my-5">
    <h1 class="header-title mb-4">Kotak Masuk Pesan & Keluhan Pelanggan</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Waktu</th>
                    <th>Nama Pengirim</th>
                    <th>Email / Telepon</th>
                    <th>Pesan Singkat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanmasuk as $pesan)
                <tr class="{{ $pesan->sudah_dibaca ? '' : 'table-info fw-bold' }}">
                    <td>{{ \Carbon\Carbon::parse($pesan->created_at)->format('d M Y H:i') }}</td>
                    <td>{{ $pesan->nama }}</td>
                    <td>{{ $pesan->email }} / {{ $pesan->telepon }}</td>
                    <td>{{ Str::limit($pesan->pesan, 80) }}</td>
                    <td>{{ $pesan->sudah_dibaca ? 'Dibaca' : 'Baru' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection