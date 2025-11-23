<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Supplier') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8 px-2 sm:px-4 lg:px-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start sm:items-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center mr-3 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Detail Supplier</h3>
                            <p class="mt-1 text-sm sm:text-base text-gray-600 dark:text-gray-400">Informasi lengkap tentang <strong>{{ $supplier->name }}</strong></p>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 sm:p-6 space-y-6 sm:space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                        
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Informasi Dasar 📋</h4>
                            
                            <div class="space-y-4">
                                @include('components.detail-item', ['label' => 'Nama Lengkap', 'value' => $supplier->name])
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Supplier</label>
                                    @php
                                        $type = $supplier->supplier_type;
                                        $typeClass = [
                                            'local' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'import' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'wholesale' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                            'retail' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'specialized' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                        ][$type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        $typeLabel = [
                                            'local' => 'Lokal',
                                            'import' => 'Impor',
                                            'wholesale' => 'Grosir',
                                            'retail' => 'Eceran',
                                            'specialized' => 'Spesialis',
                                        ][$type] ?? ucfirst($type);
                                    @endphp
                                    <p class="mt-1">
                                        <span class="px-2 py-1 text-sm font-medium rounded-full {{ $typeClass }}">
                                            {{ $typeLabel }}
                                        </span>
                                    </p>
                                </div>
                                
                                @include('components.detail-item', ['label' => 'Nama Perusahaan', 'value' => $supplier->company ?? '-'])
                                @include('components.detail-item', ['label' => 'Email', 'value' => $supplier->email])
                                @include('components.detail-item', ['label' => 'Nomor Telepon', 'value' => $supplier->phone])
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Alamat & Identitas Perusahaan 📍</h4>
                            
                            <div class="space-y-4">
                                @include('components.detail-item', ['label' => 'Alamat', 'value' => $supplier->address])
                                @include('components.detail-item', ['label' => 'Kota', 'value' => $supplier->city])
                                @include('components.detail-item', ['label' => 'Negara', 'value' => $supplier->country])
                                @include('components.detail-item', ['label' => 'NPWP Perusahaan', 'value' => $supplier->tax_id ?? '-'])
                            </div>
                        </div>
                    </div>
                    
                    @if($supplier->notes)
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Catatan Tambahan 📝</h4>
                        <p class="text-gray-900 dark:text-white p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">{{ $supplier->notes }}</p>
                    </div>
                    @endif
                    
                    <hr class="border-t border-gray-200 dark:border-gray-700">

                    <div class="mt-8">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
                            <h4 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Pesanan Terbaru (Internal) 📦</h4>
                            <a href="{{ route('suppliers.orders', $supplier) }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Lihat Semua</a>
                        </div>
                        
                        @if($recentOrders->count() > 0)
                            <div class="overflow-x-auto shadow-sm rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($recentOrders as $order)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $order->product->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $order->quantity_ordered }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                        'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                    ][$order->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                    $statusLabel = [
                                                        'pending' => 'Menunggu',
                                                        'processing' => 'Diproses',
                                                        'delivered' => 'Terkirim',
                                                        'cancelled' => 'Dibatalkan',
                                                    ][$order->status] ?? ucfirst($order->status);
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">Tidak ada pesanan terbaru.</p>
                        @endif
                    </div>

                    <hr class="border-t border-gray-200 dark:border-gray-700">

                    <div class="mt-6 sm:mt-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                            <h4 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Daftar Pembelian <span class="hidden sm:inline">(Sistem Pembelian Baru) 🧾</span></h4>
                            <a href="{{ route('purchase-orders.create', ['supplier_id' => $supplier->id]) }}" class="w-full sm:w-auto text-center px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
                                + Tambah Pembelian Baru
                            </a>
                        </div>
                        
                        @if($purchaseOrders->count() > 0)
                            <div class="overflow-x-auto shadow-sm rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nomor PO</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pembayaran</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($purchaseOrders as $purchaseOrder)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $purchaseOrder->purchase_number }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($purchaseOrder->created_at)->format('d M Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/50 dark:text-yellow-300',
                                                        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-800/50 dark:text-blue-300',
                                                        'received' => 'bg-green-100 text-green-800 dark:bg-green-800/50 dark:text-green-300',
                                                        'delivered' => 'bg-purple-100 text-purple-800 dark:bg-purple-800/50 dark:text-purple-300',
                                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-800/50 dark:text-red-300',
                                                    ][$purchaseOrder->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                    $statusLabels = [
                                                        'pending' => 'Menunggu',
                                                        'processing' => 'Diproses',
                                                        'received' => 'Diterima',
                                                        'delivered' => 'Dikirim',
                                                        'cancelled' => 'Dibatalkan',
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses }}">
                                                    {{ $statusLabels[$purchaseOrder->status] ?? $purchaseOrder->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $paymentStatus = $purchaseOrder->payment_status;
                                                    $paymentStatusClasses = [
                                                        'belum_dibayar' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/50 dark:text-yellow-300',
                                                        'dibayar' => 'bg-green-100 text-green-800 dark:bg-green-800/50 dark:text-green-300',
                                                        'gagal' => 'bg-red-100 text-red-800 dark:bg-red-800/50 dark:text-red-300',
                                                    ][$paymentStatus] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                    $paymentStatusLabels = [
                                                        'belum_dibayar' => 'Belum Dibayar',
                                                        'dibayar' => 'Lunas',
                                                        'gagal' => 'Gagal',
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $paymentStatusClasses }}">
                                                    {{ $paymentStatusLabels[$paymentStatus] ?? $paymentStatus }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('purchase-orders.show', $purchaseOrder) }}" class="text-cyan-600 hover:text-cyan-900 dark:text-cyan-400 dark:hover:text-cyan-300" title="Lihat Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" title="Edit Pembelian">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $purchaseOrders->links() }}
                            </div>
                        @else
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h4 class="mt-3 text-lg font-medium text-gray-900 dark:text-white">Belum ada pembelian</h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan menambahkan pembelian baru dari supplier ini.</p>
                                <div class="mt-4">
                                    <a href="{{ route('purchase-orders.create', ['supplier_id' => $supplier->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Buat Pembelian Baru
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <hr class="border-t border-gray-200 dark:border-gray-700">

                    <div class="mt-6 sm:mt-8">
                        <div class="mb-4">
                            <h4 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Penjualan Berdasarkan Produk <span class="hidden sm:inline">📈</span></h4>
                        </div>
                        
                        @if($salesOrders->count() > 0)
                            <div class="overflow-x-auto shadow-sm rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nomor Order</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pelanggan</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Order</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($salesOrders as $order)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $order->order_number }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $order->customer->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    // Asumsi untuk warna status (Contoh, sesuaikan dengan logic di Model/Controller jika ini dari field $order->status_*)
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                    ][$order->status ?? 'unknown'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                    $statusLabel = [
                                                        'pending' => 'Menunggu',
                                                        'processing' => 'Diproses',
                                                        'completed' => 'Selesai',
                                                        'cancelled' => 'Dibatalkan',
                                                    ][$order->status ?? 'unknown'] ?? 'Tidak Diketahui';
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $salesOrders->links() }}
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">Tidak ada penjualan yang terkait dengan produk dari supplier ini.</p>
                        @endif
                    </div>
                    
                    <hr class="border-t border-gray-200 dark:border-gray-700">
                    
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('suppliers.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                            Kembali ke Daftar
                        </a>
                        
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            Edit Supplier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Tambahkan di bawah file ini atau sebagai file component terpisah: resources/views/components/detail-item.blade.php --}}
@php
/*
<div {{ $attributes->merge(['class' => '']) }}>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <p class="mt-1 text-gray-900 dark:text-white">{{ $value ?? '-' }}</p>
</div>
*/
@endphp