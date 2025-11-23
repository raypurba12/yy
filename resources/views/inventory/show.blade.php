<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Stok') }}
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
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Detail Stok Gudang</h3>
                        </div>
                        <div>
                            <a href="{{ route('inventory.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white mr-2">
                                Kembali
                            </a>
                            <a href="{{ route('purchase-orders.create', ['supplier_id' => $inventory->supplier_id, 'product_id' => $inventory->product_id]) }}" class="px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-medium rounded-lg shadow transition duration-300 mr-2">
                                Restock
                            </a>
                            <a href="{{ route('inventory.edit', $inventory) }}" class="px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-lg shadow transition duration-300">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-1">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-4 flex items-center justify-center h-64">
                                @if($inventory->product && $inventory->product->image)
                                    <img src="{{ Storage::url($inventory->product->image) }}" alt="{{ $inventory->product->name }}" class="h-full w-full object-contain rounded-lg">
                                @else
                                    <div class="text-gray-500 dark:text-gray-400 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-2">Gambar Produk</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $inventory->product->name ?? 'N/A' }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $inventory->product->category ?? 'N/A' }}</p>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Stok Tersedia</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->quantity }}</p>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Stok Minimum</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->min_stock }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Stok Maksimum</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->max_stock }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Lokasi</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->location ?? 'N/A' }}</p>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Supplier</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->supplier->name ?? 'N/A' }}</p>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Perusahaan Supplier</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->supplier->company ?? '-' }}</p>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Berat Produk</p>
                                        <p class="text-gray-800 dark:text-white mt-1">{{ $inventory->product->weight ?? '-' }} {{ $inventory->product->unit ?? '' }}</p>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Harga Produk</p>
                                        <p class="text-gray-800 dark:text-white mt-1">Rp {{ number_format($inventory->product->price ?? 0) }}</p>
                                    </div>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <h5 class="font-medium text-gray-800 dark:text-white mb-2">Status Stok</h5>
                                    <div class="flex items-center">
                                        @if($inventory->quantity <= $inventory->min_stock)
                                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                Stok Rendah
                                            </span>
                                        @elseif($inventory->quantity == 0)
                                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Stok Habis
                                            </span>
                                        @elseif($inventory->quantity >= $inventory->max_stock)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Stok Penuh
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full dark:bg-green-900/30 dark:text-green-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Stok Cukup
                                            </span>
                                        @endif
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