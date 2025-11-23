<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 100%;
        }

        /* Header dengan Logo */
        .header {
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header-inner {
            display: table;
            width: 100%;
        }

        .logo {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
        }

        .logo img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .company-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 15px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .company-info {
            font-size: 11px;
            color: #666;
            line-height: 1.6;
        }

        .report-title {
            text-align: center;
            margin: 25px 0;
        }

        .report-title h1 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .report-date {
            font-size: 11px;
            color: #666;
        }

        /* Summary Section */
        .summary-section {
            margin: 25px 0;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table thead {
            background: #f8f9fa;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            color: #333;
            border: 1px solid #ddd;
        }

        table td {
            padding: 8px;
            font-size: 10px;
            border: 1px solid #ddd;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Total Section */
        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .total-box {
            display: inline-block;
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .total-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }

        .total-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            border: none;
            padding: 0;
            text-align: center;
            vertical-align: top;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            width: 200px;
        }

        .signature-title {
            font-size: 11px;
            margin-bottom: 60px;
        }

        .signature-name {
            font-size: 11px;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 5px;
            display: inline-block;
            min-width: 150px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-inner">
               <div class="logo">
                    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo">
                </div>
                <div class="company-text">
                    <div class="company-name">SISTEM PENJUALAN IKAN BEKU</div>
                    <div class="company-info">
                        Jl. Contoh No. 123, Kota Jambi, Indonesia<br>
                        Telp: (0741) 123456 | Email: info@ikanbeku.com
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="report-title">
            <h1>Laporan Penjualan</h1>
            <div class="report-date">
                Periode: 
                @if(request('from') && request('to'))
                    {{ \Carbon\Carbon::parse(request('from'))->format('d F Y') }} - {{ \Carbon\Carbon::parse(request('to'))->format('d F Y') }}
                @else
                    {{ date('d F Y') }}
                @endif
            </div>
            <div class="report-date">Dicetak pada: {{ date('d F Y H:i:s') }}</div>
        </div>

        <!-- All Orders Table -->
        <div class="summary-section">
            <div class="summary-title">DAFTAR SEMUA TRANSAKSI PENJUALAN</div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 15%;">No. Pesanan</th>
                        <th style="width: 20%;">Pelanggan</th>
                        <th style="width: 15%;" class="text-right">Total</th>
                        <th style="width: 15%;">Pembayaran</th>
                        <th style="width: 15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                    @endphp
                    @forelse($orders as $order)
                        @php
                            $totalAmount += $order->total_amount;
                        @endphp
                        <tr>
                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                            <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ optional($order->customer)->name ?? 'Pelanggan Umum' }}</td>
                            <td style="text-align:right;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td style="text-align:center;">{{ $order->status_label }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data transaksi penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Total -->
            @if($orders->count() > 0)
            <div class="total-section">
                <div class="total-box">
                    <div class="total-label">TOTAL PENJUALAN</div>
                    <div class="total-value">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td style="width: 50%;">
                        <div class="signature-box">
                            <div class="signature-title">Mengetahui,<br>Manager</div>
                            <div class="signature-name">(...........................)</div>
                        </div>
                    </td>
                    <td style="width: 50%;">
                        <div class="signature-box">
                            <div class="signature-title">Jambi, {{ date('d F Y') }}<br>Dibuat oleh,</div>
                            <div class="signature-name">(...........................)</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem<br>
            Sistem Penjualan Ikan Beku &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>