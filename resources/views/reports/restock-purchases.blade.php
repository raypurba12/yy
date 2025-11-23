<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Pembelian (Restock)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Report Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Pembelian (Restock)</h3>
                    </div>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Detail histori restock barang dari supplier</p>
                </div>

                <!-- Summary Cards -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Restock</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalRestocks }}</div>
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Jumlah transaksi restock</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-700/20 dark:to-blue-800/20 rounded-xl p-6 border border-blue-200 dark:border-blue-700 shadow-sm">
                        <div class="text-sm font-medium text-blue-500 dark:text-blue-400">Total Item Ditambahkan</div>
                        <div class="mt-2 text-3xl font-bold text-blue-900 dark:text-white">{{ number_format($totalRestockedItems, 0, ',', '.') }}</div>
                        <div class="mt-1 text-sm text-blue-500 dark:text-blue-400">Jumlah total item yang ditambahkan ke stok</div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-700/20 dark:to-green-800/20 rounded-xl p-6 border border-green-200 dark:border-green-700 shadow-sm">
                        <div class="text-sm font-medium text-green-500 dark:text-green-400">Rata-rata per Transaksi</div>
                        <div class="mt-2 text-3xl font-bold text-green-900 dark:text-white">{{ $totalRestocks > 0 ? number_format($totalRestockedItems / $totalRestocks, 2, ',', '.') : 0 }}</div>
                        <div class="mt-1 text-sm text-green-500 dark:text-green-400">Jumlah rata-rata item per restock</div>
                    </div>
                </div>

                <!-- Report Filters/Actions (Optional) -->
                <div class="px-6 pb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div>
                        <!-- You can add date filters here if needed -->
                    </div>
                    <div>
                        <a href="{{ route('reports.restock-purchases.export') }}" class="px-4 py-2 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl shadow transition duration-300">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Ekspor ke PDF
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Report Data Table -->
                <div class="p-6">
                    @if($restockLogs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Supplier</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Ditambahkan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($restockLogs as $log)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $log->date->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $log->inventory->product->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $log->supplier->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">+{{ number_format($log->quantity_added, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $log->notes ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $restockLogs->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada data restock untuk ditampilkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>