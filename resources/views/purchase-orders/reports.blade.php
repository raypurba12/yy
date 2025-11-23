<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Pembelian dari Suplier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Pembelian</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Kelola dan cetak laporan pembelian dari suplier</p>
                </div>
                
                <!-- Filter Section -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('purchase-orders.reports') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Awal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Filter
                            </button>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="button" onclick="window.print()" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Cetak Laporan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Summary Section -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900 dark:to-blue-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Jumlah Pembelian</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $purchaseOrders->count() }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Pembelian</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($purchaseOrders->sum('total_amount'), 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900 dark:to-yellow-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Rata-rata Pembelian</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                Rp {{ $purchaseOrders->count() > 0 ? number_format($purchaseOrders->sum('total_amount') / $purchaseOrders->count(), 0, ',', '.') : '0' }}
                            </p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-purple-100 to-violet-100 dark:from-purple-900 dark:to-violet-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Terakhir Dibuat</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $purchaseOrders->first() ? $purchaseOrders->first()->created_at->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Report Table -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Pembelian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Suplier</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($purchaseOrders as $purchaseOrder)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $purchaseOrder->purchase_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $purchaseOrder->supplier->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $purchaseOrder->created_at->format('d M Y H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data pembelian untuk periode yang dipilih
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $purchaseOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>