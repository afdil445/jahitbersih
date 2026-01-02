<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan - Lhyna Collection</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        h2, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .badge { padding: 2px 5px; border-radius: 4px; border: 1px solid #ccc; font-size: 10px; }
    </style>
</head>
<body onload="window.print()"> {{-- Otomatis muncul dialog print --}}

    <h2>LHYNA COLLECTION</h2>
    <h4>Laporan Rekapitulasi Pesanan Jahit</h4>
    <p style="text-align: center; font-size: 12px;">Dicetak pada: {{ date('d M Y, H:i') }} WIB</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Jenis Pakaian</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @php $totalOmzet = 0; @endphp
            @foreach($pesanans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>{{ $p->user->name ?? 'User Hapus' }}</td>
                <td>{{ $p->jenis_pakaian }}</td>
                <td>{{ $p->tipe_layanan }}</td>
                <td>{{ $p->status }}</td>
                <td>{{ $p->status_pembayaran }}</td>
                <td style="text-align: right;">
                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                </td>
            </tr>
            @php $totalOmzet += $p->harga; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align: right;">TOTAL OMZET</th>
                <th style="text-align: right;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>