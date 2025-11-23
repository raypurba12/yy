<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Detail Pesanan #{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white mr-2">
                                Kembali
                            </a>
                            <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg shadow transition duration-300 mr-2">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                    </svg>
                                    Cetak Struk
                                </span>
                            </a>
                            <a href="{{ route('orders.edit', $order) }}" class="px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-lg shadow transition duration-300">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-3">Item Pesanan</h4>
                                    <div class="space-y-3">
                                        @forelse($order->orderItems as $item)
                                        <div class="flex justify-between items-center pb-2 border-b border-gray-200 dark:border-gray-600">
                                            <div>
                                                <p class="font-medium text-gray-800 dark:text-white">{{ $item->product->name ?? 'N/A' }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->quantity }} x Rp {{ number_format($item->price) }}</p>
                                            </div>
                                            <p class="font-medium text-gray-800 dark:text-white">Rp {{ number_format($item->quantity * $item->price) }}</p>
                                        </div>
                                        @empty
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada item dalam pesanan ini.</p>
                                        @endforelse
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-3">Informasi Pembayaran</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Status Pembayaran:</span>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ ucfirst($order->payment_status) }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran:</span>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $order->payment_method ? ucfirst($order->payment_method) : '-' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Jumlah Diterima:</span>
                                            <p class="font-medium text-gray-800 dark:text-white">Rp {{ $order->received_amount ? number_format($order->received_amount) : '0' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Kembalian:</span>
                                            <p class="font-medium text-gray-800 dark:text-white">Rp {{ $order->change_amount ? number_format($order->change_amount) : '0' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-3">Alamat Pengiriman</h4>
                                    <p class="text-gray-800 dark:text-white">{{ $order->shipping_address ?: 'Alamat tidak tersedia' }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">Catatan</h4>
                                    <p class="text-gray-800 dark:text-white">{{ $order->notes ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-4">Ringkasan Pesanan</h4>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Pelanggan:</span>
                                        <span class="font-medium text-gray-800 dark:text-white">{{ $order->customer->name ?? 'N/A' }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">No. Pesanan:</span>
                                        <span class="font-medium text-gray-800 dark:text-white">#{{ $order->order_number }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Tanggal:</span>
                                        <span class="font-medium text-gray-800 dark:text-white">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Status Pesanan:</span>
                                        <span class="text-gray-800 dark:text-white">
                                            <span class="px-2 py-1 bg-{{ $order->status_bg_color }} text-{{ $order->status_text_color }} text-xs font-medium rounded-full dark:bg-{{ $order->status_bg_dark_color }} dark:text-{{ $order->status_text_dark_color }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Status Pembayaran:</span>
                                        <span class="font-medium text-gray-800 dark:text-white">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </span>
                                    </div>
                                    
                                    <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span class="text-gray-800 dark:text-white">Total:</span>
                                            <span class="text-gray-800 dark:text-white">Rp {{ number_format($order->total_amount) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>