<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stock</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Header dengan Logo */
        .header {
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-inner {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .company-text {
            flex: 1;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .company-info {
            font-size: 12px;
            color: #666;
            line-height: 1.5;
        }

        .report-title {
            text-align: center;
            margin: 30px 0;
        }

        .report-title h1 {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .report-date {
            font-size: 12px;
            color: #666;
        }

        /* Summary Cards */
        .summary-section {
            margin: 30px 0;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .summary-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .summary-card .label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        /* Table */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table thead {
            background: #f8f9fa;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            border: 1px solid #ddd;
        }

        table td {
            padding: 10px 12px;
            font-size: 12px;
            border: 1px solid #ddd;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-box .title {
            font-size: 12px;
            margin-bottom: 60px;
        }

        .signature-box .name {
            font-size: 12px;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 5px;
            display: inline-block;
            min-width: 150px;
        }

        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                background: #ffffff;
            }

            .container {
                max-width: 100%;
                padding: 16px;
                box-shadow: none;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .signature-section {
                flex-direction: column;
                gap: 24px;
            }

            .signature-box {
                width: 100%;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 20px;
                max-width: 210mm;
            }

            .no-print {
                display: none;
            }

            @page {
                margin: 1cm;
            }
        }

        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .print-button:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
   

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-inner">
                <div class="logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo FreshFreeze">
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
            <h1>Laporan Stock</h1>
            <div class="report-date">Periode: {{ date('d F Y') }}</div>
        </div>

        <!-- Action Buttons (PDF & Excel) -->
        <div class="summary-section no-print" style="margin-top: 10px; margin-bottom: 0;">
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('reports.export', ['type' => 'inventory']) }}" 
                   style="background:#2563eb;color:#fff;padding:8px 14px;border-radius:4px;text-decoration:none;font-size:13px;">
                    Download PDF
                </a>
                <a href="{{ route('reports.inventory.export-excel') }}" 
                   style="background:#16a34a;color:#fff;padding:8px 14px;border-radius:4px;text-decoration:none;font-size:13px;">
                    Download Excel
                </a>
                <button type="button" onclick="window.print()"
                        style="background:#2563eb;color:#fff;padding:8px 14px;border-radius:4px;text-decoration:none;font-size:13px;border:none;cursor:pointer;">
                    Cetak Laporan
                </button>
               
            </div>
        </div>

       

        <!-- All Orders Table -->
        <div class="summary-section">
            <div class="summary-title">DAFTAR SEMUA STOCK</div>

            <!-- Filter Tanggal (disembunyikan saat cetak) -->
            <form method="GET" action="{{ route('reports.inventory') }}" class="no-print" style="margin-bottom:15px;">
                <div style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
                    <div>
                        <label for="from" style="font-size:12px;color:#555;">Dari Tanggal</label><br>
                        <input type="date" id="from" name="from" value="{{ request('from') }}" 
                               style="padding:4px 6px;font-size:12px;border:1px solid #ccc;border-radius:4px;">
                    </div>
                    <div>
                        <label for="to" style="font-size:12px;color:#555;">Sampai Tanggal</label><br>
                        <input type="date" id="to" name="to" value="{{ request('to') }}" 
                               style="padding:4px 6px;font-size:12px;border:1px solid #ccc;border-radius:4px;">
                    </div>
                    <div>
                        <button type="submit" 
                                style="background:#2563eb;color:#fff;padding:6px 12px;border:none;border-radius:4px;font-size:12px;cursor:pointer;">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('reports.inventory') }}" 
                           style="margin-left:5px;background:#6b7280;color:#fff;padding:6px 12px;border-radius:4px;font-size:12px;text-decoration:none;">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:5%;text-align:center;">No</th>
                            <th style="width:25%;">Nama Produk</th>
                            <th style="width:15%;text-align:center;">Kategori</th>
                            <th style="width:15%;text-align:right;">Jumlah Stok</th>
                            <th style="width:15%;text-align:right;">Stok Minimal</th>
                            <th style="width:15%;text-align:right;">Stok Maksimal</th>  
                            <th style="width:10%;text-align:center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $inventory)
                            <tr>
                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                <td>{{ optional($inventory->product)->name }}</td>
                                <td style="text-align:center;">{{ optional($inventory->product)->category }}</td>
                                <td style="text-align:right;">{{ $inventory->quantity }}</td>
                                <td style="text-align:right;">{{ $inventory->min_stock }}</td>
                                <td style="text-align:right;">{{ $inventory->max_stock }}</td>
                                <td style="text-align:center;">
                                    @if($inventory->quantity <= $inventory->min_stock)
                                        Rendah
                                    @elseif($inventory->quantity >= $inventory->max_stock)
                                        Penuh
                                    @else
                                        Normal
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;">Belum ada data stock.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="title">Mengetahui,<br>Manager</div>
                <div class="name">(...........................)</div>
            </div>
            <div class="signature-box">
                <div class="title">Jambi, {{ date('d F Y') }}<br>Dibuat oleh,</div>
                <div class="name">(...........................)</div>
            </div>
        </div>
    </div>
</body>
</html>