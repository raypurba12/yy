<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Detail Pembelian</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">Nomor: {{ $purchaseOrder->purchase_number }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('purchase-orders.receipt', $purchaseOrder) }}" target="_blank" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Cetak Struk
                            </a>
                            <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="px-4 py-2 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Purchase Order Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Informasi Suplier</h4>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Nama:</span> {{ $purchaseOrder->supplier->name }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Telepon:</span> {{ $purchaseOrder->supplier->phone }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Email:</span> {{ $purchaseOrder->supplier->email }}
                                </p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Detail Pembelian</h4>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Nomor Pembelian:</span> {{ $purchaseOrder->purchase_number }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Tanggal:</span> {{ $purchaseOrder->created_at->format('d M Y H:i') }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Status:</span> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $purchaseOrder->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}
                                        {{ $purchaseOrder->status == 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : '' }}
                                        {{ $purchaseOrder->status == 'received' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                                        {{ $purchaseOrder->status == 'delivered' ? 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100' : '' }}
                                        {{ $purchaseOrder->status == 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}">
                                        {{ $purchaseOrder->status == 'pending' ? 'Baru' : '' }}
                                        {{ $purchaseOrder->status == 'processing' ? 'Diproses' : '' }}
                                        {{ $purchaseOrder->status == 'received' ? 'Diterima' : '' }}
                                        {{ $purchaseOrder->status == 'delivered' ? 'Dikirim' : '' }}
                                        {{ $purchaseOrder->status == 'cancelled' ? 'Dibatalkan' : '' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Items -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-4">Item Pembelian</h4>
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuantitas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($purchaseOrder->purchaseOrderItems as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">{{ $item->quantity }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-4">Informasi Pembayaran</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="space-y-2">
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Status Pembayaran:</span> 
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $purchaseOrder->payment_status == 'belum_dibayar' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}
                                            {{ $purchaseOrder->payment_status == 'dibayar' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                                            {{ $purchaseOrder->payment_status == 'gagal' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}">
                                            {{ $purchaseOrder->payment_status == 'belum_dibayar' ? 'Belum Dibayar' : '' }}
                                            {{ $purchaseOrder->payment_status == 'dibayar' ? 'Dibayar' : '' }}
                                            {{ $purchaseOrder->payment_status == 'gagal' ? 'Gagal' : '' }}
                                        </span>
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Metode Pembayaran:</span> 
                                        @if($purchaseOrder->payment_method)
                                            {{ ucfirst($purchaseOrder->payment_method) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div>
                                <div class="space-y-2">
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Total Pembayaran:</span> 
                                        Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Jumlah Diterima:</span> 
                                        @if($purchaseOrder->received_amount)
                                            Rp {{ number_format($purchaseOrder->received_amount, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Kembalian:</span> 
                                        @if($purchaseOrder->change_amount)
                                            Rp {{ number_format($purchaseOrder->change_amount, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($purchaseOrder->notes)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Catatan</h4>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                <p class="text-gray-600 dark:text-gray-300">{{ $purchaseOrder->notes }}</p>
                            </div>
                        </div>
                    @endif>

                    <div class="flex justify-end">
                        <a href="{{ route('purchase-orders.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl shadow-md transition-all duration-300">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>