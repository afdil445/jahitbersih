<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan Lhyna Collection</title>
    <style>
        body { font-family: sans-serif; }
        
        /* KOP SURAT */
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #333; }
        .header p { margin: 2px; font-size: 14px; color: #555; }
        .line { border-bottom: 2px solid #000; margin-bottom: 30px; }

        /* TABEL DATA */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #333; }
        th { background-color: #f2f2f2; padding: 10px; text-align: left; }
        td { padding: 8px; font-size: 12px; }
        
        /* TOTAL HARGA */
        .total-row { font-weight: bold; background-color: #e6e6e6; }
        
        /* TANDA TANGAN */
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LHYNA COLLECTION</h1>
        <p>Jasa Jahit Profesional & Berkualitas</p>
        <p>Jl. Contoh Alamat No. 123, Parepare - Sulawesi Selatan</p>
        <p>Telp/WA: 0812-3456-7890</p>
    </div>
    <div class="line"></div>

    <h3 style="text-align: center;">LAPORAN PENDAPATAN JASA JAHIT</h3>
    <p>Tanggal Cetak: {{ date('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Jenis Pakaian</th>
                <th>Tgl Order</th>
                <th>Status</th>
                <th>Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->user->name ?? 'User Terhapus' }}</td>
                <td>
                    {{ $item->jenis_pakaian }}<br>
                    <small><i>({{ $item->jenis_layanan }})</i></small>
                </td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td style="text-transform: uppercase;">{{ $item->status_pembayaran }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data pesanan yang selesai.</td>
            </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="5" style="text-align: right;">TOTAL PENDAPATAN</td>
                <td style="text-align: right;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Parepare, {{ date('d F Y') }}</p>
        <p>Pemilik Usaha,</p>
        <div class="signature">Herlina (Lhyna)</div>
    </div>

</body>
</html>