<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan - Lhyna Collection</title>
    {{-- Kita pinjam CSS Bootstrap biar tabelnya rapi --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus Cetak */
        body {
            font-family: sans-serif;
        }

        .kop-surat {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .tanda-tangan {
            margin-top: 50px;
            text-align: right;
            margin-right: 50px;
        }

        @media print {
            .no-print {
                display: none;
            }

            /* Tombol kembali hilang saat diprint */
        }
    </style>
</head>

<body onload="window.print()"> {{-- Otomatis muncul dialog print saat dibuka --}}

    <div class="container mt-4">
        {{-- Tombol Kembali (Hanya muncul di layar) --}}
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary no-print mb-3">Kembali ke Admin</a>

        {{-- Kop Laporan --}}
        <div class="text-center kop-surat">
            <h2 class="fw-bold">LHYNA COLLECTION</h2>
            <p>Jasa Jahit & Vermak Profesional<br>
                Kabupaten Sidenreng Rappang (Sidrap), Sulawesi Selatan</p>
        </div>

        <h4 class="text-center mb-4">LAPORAN REKAPITULASI PESANAN</h4>
        <p class="text-muted small">Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>

        {{-- Tabel Data --}}
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tgl Masuk</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $index => $pesanan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pesanan->created_at->format('d/m/Y') }}</td>
                        <td>{{ $pesanan->nama ?? $pesanan->user->name }}</td>
                        <td>{{ $pesanan->tipe_layanan }} - {{ $pesanan->jenis_pakaian }}</td>
                        <td>{{ $pesanan->status }}</td>
                        <td>{{ $pesanan->status_pembayaran }}</td>
                        <td class="text-end">{{ number_format($pesanan->harga ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Area Tanda Tangan --}}
        <div class="tanda-tangan">
            <p>Mengetahui,<br>Pemilik Usaha</p>
            <br><br><br>
            <p class="fw-bold text-decoration-underline">Admin Lhyna Collection</p>
        </div>
    </div>

</body>

</html>
