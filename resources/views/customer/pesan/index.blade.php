@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white p-4 rounded-top-4">
            <h4 class="mb-0 fw-bold"><i class="bi bi-envelope-paper me-2"></i> Kotak Pesan Saya</h4>
        </div>
        <div class="card-body p-4">
            
            {{-- PERBAIKAN: Pastikan variabelnya $pesanans (bukan $pesans) --}}
            @if($pesanans->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted opacity-25"></i>
                    <p class="mt-3 text-muted">Anda belum pernah mengirim pesan ke Admin.</p>
                    <a href="{{ route('kontak.create') }}" class="btn btn-outline-primary rounded-pill">
                        Mulai Chat Admin
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Subjek</th>
                                <th>Pesan Anda</th>
                                <th>Balasan Admin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- PERBAIKAN: Loop juga harus menggunakan $pesanans --}}
                            @foreach($pesanans as $item)
                            <tr>
                                <td class="text-muted small" style="width: 15%;">
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="fw-bold text-primary">{{ $item->subjek }}</td>
                                <td style="width: 30%;">{{ $item->pesan }}</td>
                                
                                <td style="width: 30%;">
                                    @if($item->balasan) 
                                        <div class="alert alert-success py-2 px-3 mb-0 small">
                                            <i class="bi bi-check-circle-fill me-1"></i> 
                                            {{ $item->balasan }}
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic small">Menunggu balasan...</span>
                                    @endif
                                </td>

                                <td>
                                    @if($item->status == 'dibaca' || $item->balasan)
                                        <span class="badge bg-success rounded-pill">Dijawab/Dibaca</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Terkirim</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection