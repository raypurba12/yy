<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 1rem;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="receipt-container">
        <!-- Receipt Header -->
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold">FRESHFREEZE</h1>
            <p class="text-sm">Sistem Penjualan Ikan Beku</p>
            <p class="text-xs">Jl. Contoh Alamat No. 123</p>
            <p class="text-xs">Telp: (021) 12345678</p>
        </div>
        
        <!-- Order Info -->
        <div class="border-b border-gray-300 pb-2 mb-4">
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <p><span class="font-semibold">Nomor Order:</span></p>
                    <p>{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p><span class="font-semibold">Tanggal:</span></p>
                    <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <div class="mt-2">
                <p><span class="font-semibold">Nama Pelanggan:</span></p>
                <p>{{ $order->customer->name ?? 'Pelanggan Umum' }}</p>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="mb-4">
            @foreach($order->orderItems as $item)
            <div class="flex justify-between py-1 text-sm">
                <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        
        <!-- Payment Summary -->
        @php
            $subtotal = $order->orderItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
            $discountAmount = max(0, $subtotal - $order->total_amount);
        @endphp

        <div class="border-t border-gray-300 pt-2 mb-4">
            <div class="flex justify-between py-1">
                <span class="font-semibold">Subtotal:</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            @if($discountAmount > 0)
            <div class="flex justify-between py-1">
                <span>Diskon:</span>
                <span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
            </div>
            @endif
            
            @if($order->received_amount)
            <div class="flex justify-between py-1">
                <span>Uang Diterima:</span>
                <span>Rp {{ number_format($order->received_amount, 0, ',', '.') }}</span>
            </div>
            
            @if($order->change_amount !== null)
            <div class="flex justify-between py-1">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($order->change_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            @endif
            
            <div class="flex justify-between py-1 border-t border-gray-300 mt-1">
                <span class="font-bold text-lg">Total:</span>
                <span class="font-bold text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            
            @if(!empty($order->notes))
            <div class="mt-2 text-xs">
                <span class="font-semibold">Catatan:</span>
                <p>{{ $order->notes }}</p>
            </div>
            @endif
            
            <div class="mt-2">
                <p><span class="font-semibold">Metode Pembayaran:</span> 
                @if($order->payment_method === 'cash')
                    Cash
                @elseif($order->payment_method === 'transfer')
                    Transfer
                @elseif($order->payment_method === 'qris')
                    QRIS
                @else
                    -
                @endif
                </p>
            </div>
        </div>
        
        <!-- Payment Status -->
        <div class="text-center mb-4">
            <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm font-semibold">
                {{ $order->payment_status === 'dibayar' ? 'DIBAYAR' : 'BELUM DIBAYAR' }}
            </span>
        </div>
        
        <!-- Receipt Footer -->
        <div class="text-center border-t border-gray-300 pt-4 text-xs">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Silakan simpan struk ini sebagai bukti pembelian</p>
        </div>
        
        <!-- Print Button -->
        <div class="text-center mt-6 no-print">
            <button 
                onclick="window.print()" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Cetak Struk
            </button>
            <button 
                onclick="window.close()" 
                class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
            >
                Tutup
            </button>
        </div>
    </div>
</body>
</html>