<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stok Gudang') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-x-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Daftar Stok Gudang</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">Kelola stok produk ikan beku Anda dengan mudah</p>
                        </div>
                        @if(Auth::user()->hasRole('admin'))
                        
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Search and Filter --}}
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                        <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500" 
                                           placeholder="Cari produk...">
                                </div>
                            </div>
                            <div class="w-full md:w-48">
                                <select name="status" onchange="this.form.submit()" 
                                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                                    <option value="">Semua Status</option>
                                    <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
                                    <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Habis</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Stok Penuh</option>
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg shadow-md transition duration-200">
                                Cari
                            </button>
                        </form>
                    </div>
                    
                    {{-- Inventory Table --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden text-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr class="text-xs">
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Supplier</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stok</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Min/Max</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-3 py-2 text-right font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($inventories as $inventory)
                                    @php
                                        $stockPercentage = $inventory->max_stock > 0 ? ($inventory->quantity / $inventory->max_stock) * 100 : 0;
                                        $stockPercentage = min(100, max(0, $stockPercentage)); // Ensure between 0-100
                                        
                                        $status = 'available';
                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
                                        $statusIcon = 'M5 13l4 4L19 7';
                                        
                                        if ($inventory->quantity <= 0) {
                                            $status = 'out';
                                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
                                            $statusIcon = 'M6 18L18 6M6 6l12 12';
                                        } elseif ($inventory->quantity <= $inventory->min_stock) {
                                            $status = 'low';
                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
                                            $statusIcon = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                                        } elseif ($inventory->quantity >= $inventory->max_stock) {
                                            $status = 'full';
                                            $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300';
                                            $statusIcon = 'M5 13l4 4L19 7';
                                        }
                                    @endphp
                                    
                                    <tr id="inventory-row-{{ $inventory->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 text-xs font-medium mr-2">
                                                    @if(isset($inventory->product->image) && file_exists(public_path('storage/' . $inventory->product->image)))
                                                        <img src="{{ asset('storage/' . $inventory->product->image) }}" alt="{{ $inventory->product->name }}" class="h-8 w-8 rounded-full object-cover">
                                                    @else
                                                        {{ substr($inventory->product->name ?? 'N/A', 0, 1) }}
                                                    @endif
                                                </div>
                                                <div class="truncate max-w-[150px]">
                                                    <div class="font-medium text-gray-900 dark:text-white truncate">{{ $inventory->product->name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $inventory->product->category ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="text-gray-900 dark:text-white">{{ $inventory->supplier->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[120px]">{{ $inventory->supplier->company ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $inventory->quantity }} <span class="text-xs text-gray-500">{{ $inventory->product->unit ?? 'pcs' }}</span></div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1 dark:bg-gray-700">
                                                <div class="bg-{{ $status === 'low' ? 'yellow' : ($status === 'out' ? 'red' : ($status === 'full' ? 'blue' : 'green')) }}-600 h-1.5 rounded-full" style="width: {{ $stockPercentage }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($stockPercentage, 1) }}%</div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="text-gray-900 dark:text-white text-xs">
                                                <span class="font-medium">Min:</span> {{ $inventory->min_stock }}<br>
                                                <span class="font-medium">Maks:</span> {{ $inventory->max_stock }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <svg class="h-3.5 w-3.5 text-gray-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="text-gray-900 dark:text-white text-xs">{{ $inventory->location ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <span class="px-2 py-0.5 inline-flex items-center text-xs font-medium rounded-full {{ $statusClass }}">
                                                <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcon }}" />
                                                </svg>
                                                @if($status === 'low')
                                                    Rendah
                                                @elseif($status === 'out')
                                                    Habis
                                                @elseif($status === 'full')
                                                    Penuh
                                                @else
                                                    Tersedia
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-right font-medium">
                                            <div class="flex justify-end space-x-0.5">
                                                <a href="{{ route('inventory.show', $inventory) }}" 
                                                   class="p-1 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                                   title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('inventory.edit', $inventory) }}" 
                                                   class="p-1 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900/20"
                                                   title="Edit Stok">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                @if(Auth::user()->hasRole('admin'))
                                                <button 
                                                    type="button" 
                                                    class="p-1 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                                                    onclick="openDeleteModal('{{ route('inventory.destroy', $inventory) }}', 'Stok: {{ $inventory->product->name ?? 'N/A' }}', () => removeElement('inventory-row-{{ $inventory->id }}'))"
                                                    title="Hapus Stok">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    @if(request('search') || request('status'))
                                                        Tidak ada stok yang cocok dengan pencarian
                                                    @else
                                                        Belum ada data stok gudang
                                                    @endif
                                                </h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    @if(request('search') || request('status'))
                                                        Coba gunakan kata kunci lain atau hapus filter
                                                    @else
                                                        Mulai dengan menambahkan stok baru
                                                    @endif
                                                </p>
                                                @if(Auth::user()->hasRole('admin'))
                                                <a href="{{ route('inventory.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors duration-200">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    Tambah Stok Baru
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </table>
                        </div>
                    </div>
                
                    <div class="mt-6">
                        {{ $inventories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Scrollbar */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #06b6d4, #3b82f6);
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #0891b2, #2563eb);
        }

        /* Dark mode scrollbar */
        .dark .overflow-x-auto {
            scrollbar-color: #4b5563 #1f2937;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #0891b2, #2563eb);
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #06b6d4, #3b82f6);
        }
    </style>
</x-app-layout>