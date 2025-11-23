<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian (Restock) - {{ date('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary div {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.8em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pembelian (Restock)</h1>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div><strong>Total Restock:</strong> {{ $totalRestocks }}</div>
        <div><strong>Total Item Ditambahkan:</strong> {{ number_format($totalRestockedItems, 0, ',', '.') }}</div>
        <div><strong>Rata-rata per Transaksi:</strong> {{ $totalRestocks > 0 ? number_format($totalRestockedItems / $totalRestocks, 2, ',', '.') : 0 }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Supplier</th>
                <th>Jumlah Ditambahkan</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($restockLogs as $log)
            <tr>
                <td>{{ $log->date->format('d/m/Y H:i') }}</td>
                <td>{{ $log->inventory->product->name ?? 'N/A' }}</td>
                <td>{{ $log->supplier->name ?? 'N/A' }}</td>
                <td>+{{ number_format($log->quantity_added, 0, ',', '.') }}</td>
                <td>{{ $log->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan dibuat secara otomatis oleh sistem.</p>
    </div>
</body>
</html>