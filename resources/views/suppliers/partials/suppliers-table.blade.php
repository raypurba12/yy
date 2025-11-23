<!-- Desktop Table -->
<div class="hidden md:block">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Perusahaan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kontak</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($suppliers as $supplier)
                <tr id="supplier-row-{{ $supplier->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($supplier->image && file_exists(public_path('storage/' . $supplier->image)))
                                <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden border-2 border-white dark:border-gray-700 shadow-sm">
                                    <img class="h-full w-full object-cover" src="{{ asset('storage/' . $supplier->image) }}" alt="{{ $supplier->name }}">
                                </div>
                            @else
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                    {{ strtoupper(substr($supplier->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $supplier->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @php
                                        $types = [
                                            'local' => 'Lokal',
                                            'import' => 'Impor',
                                            'wholesale' => 'Grosir',
                                            'retail' => 'Eceran',
                                            'specialized' => 'Spesialis'
                                        ];
                                        $type = $types[$supplier->supplier_type] ?? $supplier->supplier_type;
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ 
                                        $supplier->supplier_type === 'local' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 
                                        ($supplier->supplier_type === 'import' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : 
                                        ($supplier->supplier_type === 'wholesale' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200' : 
                                        ($supplier->supplier_type === 'retail' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' : 
                                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'))) 
                                    }}">
                                        {{ $type }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $supplier->company ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate max-w-[150px] block">{{ $supplier->email ?? '-' }}</span>
                            </div>
                            <div class="flex items-center mt-1">
                                <svg class="h-4 w-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $supplier->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">
                    {{ $supplier->city ?? '-' }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $supplier->country ?? '-' }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('suppliers.show', $supplier) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Lihat Detail">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                    @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <button type="button" 
                            onclick="openDeleteModal('{{ route('suppliers.destroy', $supplier) }}', '{{ $supplier->name }}', () => window.location.reload())"
                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                            title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </td>
</tr>
        @empty
        <tr>
            <td colspan="6" class="px-4 sm:px-6 py-8 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">Tidak ada supplier yang ditemukan</p>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 px-2">
                        @if(request()->has('search') && !empty(request('search')))
                            Tidak ada hasil untuk "{{ request('search') }}"
                        @else
                            Belum ada data supplier yang tersedia
                        @endif
                    </p>
                    @if(Auth::user()->hasRole('admin') && (!request()->has('search') || empty(request('search'))))
                    <a href="{{ route('suppliers.create') }}" class="mt-3 sm:mt-4 inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm transition-colors duration-150">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="whitespace-nowrap">Tambah Supplier</span>
                    </a>
                    @endif
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

<!-- Mobile Cards -->
<div class="md:hidden space-y-3">
    @forelse($suppliers as $supplier)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="p-4">
            <div class="flex items-start">
                @if($supplier->image && file_exists(public_path('storage/' . $supplier->image)))
                    <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden border-2 border-white dark:border-gray-700 shadow-sm">
                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . $supplier->image) }}" alt="{{ $supplier->name }}">
                    </div>
                @else
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center text-white font-semibold text-lg shadow-md">
                        {{ strtoupper(substr($supplier->name, 0, 1)) }}
                    </div>
                @endif
                <div class="ml-3 flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ $supplier->name }}</h3>
                        <div class="flex space-x-1">
                            <a href="{{ route('suppliers.show', $supplier) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Lihat Detail">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300" title="Edit">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    @php
                        $types = [
                            'local' => 'Lokal',
                            'import' => 'Impor',
                            'wholesale' => 'Grosir',
                            'retail' => 'Eceran',
                            'specialized' => 'Spesialis'
                        ];
                        $type = $types[$supplier->supplier_type] ?? $supplier->supplier_type;
                    @endphp
                    <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                        $supplier->supplier_type === 'local' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 
                        ($supplier->supplier_type === 'import' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : 
                        ($supplier->supplier_type === 'wholesale' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200' : 
                        ($supplier->supplier_type === 'retail' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' : 
                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'))) 
                    }}">
                        {{ $type }}
                    </span>
                    
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                        @if($supplier->company)
                        <div class="flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {{ $supplier->company }}
                        </div>
                        @endif
                        
                        @if($supplier->email)
                        <div class="flex items-center mt-1">
                            <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $supplier->email }}
                        </div>
                        @endif
                        
                        @if($supplier->phone)
                        <div class="flex items-center mt-1">
                            <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $supplier->phone }}
                        </div>
                        @endif
                        
                        @if($supplier->city || $supplier->country)
                        <div class="flex items-start mt-1">
                            <svg class="h-4 w-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $supplier->city }}{{ $supplier->city && $supplier->country ? ', ' : '' }}{{ $supplier->country }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if(Auth::user()->hasRole('admin'))
            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="button" 
                        onclick="openDeleteModal('{{ route('suppliers.destroy', $supplier) }}', '{{ $supplier->name }}', () => window.location.reload())"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Hapus
                </button>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-8">
        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada supplier</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            @if(request()->has('search') && !empty(request('search')))
                Tidak ditemukan supplier dengan kata kunci "{{ request('search') }}"
            @else
                Belum ada data supplier yang tersedia
            @endif
        </p>
        @if(Auth::user()->hasRole('admin') && (!request()->has('search') || empty(request('search'))))
            <div class="mt-6">
                <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Supplier Baru
                </a>
            </div>
        @endif
    </div>
    @endforelse
</div>
