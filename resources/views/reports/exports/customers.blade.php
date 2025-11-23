<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelanggan</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #a855f7;
        }
        .company-info {
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #7e22ce;
            margin-bottom: 5px;
        }
        .company-subtitle {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 10px;
        }
        .report-title {
            font-size: 22px;
            font-weight: bold;
            color: #7e22ce;
            margin: 20px 0 10px 0;
        }
        .report-date {
            font-size: 14px;
            color: #6b7280;
        }
        .summary-section {
            margin: 25px 0;
            padding: 15px;
            background-color: #faf5ff;
            border: 1px solid #e9d5ff;
            border-radius: 8px;
        }
        .summary-title {
            font-size: 18px;
            font-weight: bold;
            color: #7e22ce;
            margin-bottom: 15px;
            text-align: center;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .summary-card {
            border: 1px solid #c4b5fd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: white;
        }
        .summary-card-title {
            font-size: 14px;
            color: #6d28d9;
            margin-bottom: 8px;
        }
        .summary-card-value {
            font-size: 20px;
            font-weight: bold;
            color: #7e22ce;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #7e22ce;
            margin: 30px 0 15px 0;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
            background-color: white;
            border: 1px solid #cbd5e1;
        }
        th {
            background-color: #f3e8ff;
            color: #6d28d9;
            font-weight: bold;
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #c4b5fd;
        }
        td {
            padding: 10px 15px;
            border: 1px solid #e9d5ff;
        }
        tr:nth-child(even) {
            background-color: #faf5ff;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
        }
        .signature {
            width: 200px;
            text-align: center;
        }
        .signature-label {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 10px;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">SISTEM PENJUALAN IKAN BEKU</div>
            <div class="company-subtitle">Laporan Analisis Pelanggan</div>
        </div>
        <div class="report-title">LAPORAN PELANGGAN</div>
        <div class="report-date">Dibuat pada: {{ date('d F Y H:i:s') }}</div>
    </div>

    <div class="summary-section">
        <div class="summary-title">RINGKASAN PELANGGAN</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-card-title">TOTAL PELANGGAN</div>
                <div class="summary-card-value">{{ number_format($customerStats['total'] ?? 0) }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-title">PELANGGAN BARU BULAN INI</div>
                <div class="summary-card-value">{{ number_format($customerStats['newThisMonth'] ?? 0) }}</div>
            </div>
        </div>
    </div>

    @if(isset($topCustomers) && count($topCustomers) > 0)
    <div class="section-title">PELANGGAN TERATAS</div>
    <table>
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Jumlah Pesanan</th>
                <th>Total Pembelian</th>
                <th>Rata-rata Per Pesanan</th>
                <th>Terakhir Belanja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topCustomers as $customer)
            <tr>
                <td>{{ $customer->customer->name ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $customer->order_count }}</td>
                <td style="text-align: right;">Rp {{ number_format($customer->total_spent) }}</td>
                <td style="text-align: right;">Rp {{ number_format($customer->total_spent / max(1, $customer->order_count)) }}</td>
                <td>{{ $customer->customer->orders()->latest()->first() ? $customer->customer->orders()->latest()->first()->created_at->format('d F Y') : 'Tidak ada pesanan' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="signature-section">
        <div class="signature">
            <div>Mengetahui,</div>
            <div style="height: 60px;"></div>
            <div class="signature-label">Manager Pelayanan</div>
        </div>
    </div>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh sistem<br>
        Sistem Penjualan Ikan Beku &copy; {{ date('Y') }}
    </div>
</body>
</html>