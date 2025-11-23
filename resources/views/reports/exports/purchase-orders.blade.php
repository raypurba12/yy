<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembelian dari Suplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .summary-card {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        .summary-card h3 {
            margin: 0 0 5px 0;
            font-size: 12px;
            color: #666;
        }
        .summary-card p {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMBELIAN DARI SUPLIER</h1>
        <p>{{ now()->format('d F Y H:i:s') }}</p>
    </div>
    
    <div class="summary">
        <div class="summary-card">
            <h3>Hari Ini</h3>
            <p>Rp {{ number_format($purchaseOrderStats['today'], 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Minggu Ini</h3>
            <p>Rp {{ number_format($purchaseOrderStats['thisWeek'], 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Bulan Ini</h3>
            <p>Rp {{ number_format($purchaseOrderStats['thisMonth'], 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Tahun Ini</h3>
            <p>Rp {{ number_format($purchaseOrderStats['thisYear'], 0, ',', '.') }}</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchaseOrdersByDate as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</td>
                    <td>Rp {{ number_format($data->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada data pembelian untuk periode yang dipilih</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>