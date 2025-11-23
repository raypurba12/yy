<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian - {{ $purchaseOrder->purchase_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .receipt-header h2 {
            margin: 0;
            color: #1f2937;
        }
        .receipt-info {
            margin-bottom: 15px;
        }
        .receipt-info div {
            margin-bottom: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .items-table th, .items-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f9fafb;
        }
        .total-section {
            text-align: right;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h2>STRUK PEMBELIAN</h2>
        </div>
        
        <div class="receipt-info">
            <div><strong>No. Pembelian:</strong> {{ $purchaseOrder->purchase_number }}</div>
            <div><strong>Suplier:</strong> {{ $purchaseOrder->supplier->name }}</div>
            <div><strong>Tanggal:</strong> {{ $purchaseOrder->created_at->format('d M Y H:i') }}</div>
            <div><strong>Status:</strong> 
                {{ $purchaseOrder->status == 'pending' ? 'Baru' : '' }}
                {{ $purchaseOrder->status == 'processing' ? 'Diproses' : '' }}
                {{ $purchaseOrder->status == 'received' ? 'Diterima' : '' }}
                {{ $purchaseOrder->status == 'delivered' ? 'Dikirim' : '' }}
                {{ $purchaseOrder->status == 'cancelled' ? 'Dibatalkan' : '' }}
            </div>
        </div>
        
        <table class="items-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->purchaseOrderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total-section">
            <div><strong>Total: Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</strong></div>
            <div>Metode Pembayaran: {{ $purchaseOrder->payment_method ? ucfirst($purchaseOrder->payment_method) : '-' }}</div>
            <div>Status Pembayaran: 
                {{ $purchaseOrder->payment_status == 'belum_dibayar' ? 'Belum Dibayar' : '' }}
                {{ $purchaseOrder->payment_status == 'dibayar' ? 'Dibayar' : '' }}
                {{ $purchaseOrder->payment_status == 'gagal' ? 'Gagal' : '' }}
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih atas pembelian Anda</p>
            <p>{{ config('app.name', 'Aplikasi') }}</p>
        </div>
    </div>

    <script>
        // Automatically print when the page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>