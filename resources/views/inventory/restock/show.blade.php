<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pembelian dari Supplier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Purchase Details -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Detail Pembelian</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">Nomor: {{ $restock->restock_number }}</p>
                        </div>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($restock->payment_status === 'dibayar') 
                                bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @elseif($restock->payment_status === 'belum_dibayar')
                                bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                            @else
                                bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                            @endif">
                            {{ $restock->payment_status === 'dibayar' ? 'Dibayar' : ($restock->payment_status === 'belum_dibayar' ? 'Belum Dibayar' : 'Gagal') }}
                        </span>
                    </div>
                </div>

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Informasi Supplier</h4>
                            <div class="space-y-2">
                                <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Nama:</span> {{ $restock->supplier->name }}</p>
                                <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Email:</span> {{ $restock->supplier->email }}</p>
                                <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Telepon:</span> {{ $restock->supplier->phone }}</p>
                                <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Alamat:</span> {{ $restock->supplier->address }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Detail Pembelian</h4>
                            <div class="space-y-2">
                                <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($restock->purchase_date)->format('d M Y') }}</p>
                                <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Total:</span> Rp {{ number_format($restock->total_amount, 0, ',', '.') }}</p>
                                @if($restock->payment_method)
                                    <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Metode Pembayaran:</span> {{ $restock->payment_method === 'cash' ? 'Cash' : ($restock->payment_method === 'transfer' ? 'Transfer' : 'QRIS') }}</p>
                                @endif
                                @if($restock->received_amount)
                                    <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Jumlah Diterima:</span> Rp {{ number_format($restock->received_amount, 0, ',', '.') }}</p>
                                @endif
                                @if($restock->change_amount)
                                    <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Kembalian:</span> Rp {{ number_format($restock->change_amount, 0, ',', '.') }}</p>
                                @endif
                                @if($restock->notes)
                                    <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Catatan:</span> {{ $restock->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Item yang Dibeli</h3>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Ikan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Beli (Rp/Kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah (Kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($restock->restockItems as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ number_format($item->quantity, 2, ',', '.') }} Kg</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada item pembelian
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-end">
                            <div class="w-1/3">
                                <div class="flex justify-between py-2">
                                    <span class="text-lg font-medium text-gray-800 dark:text-white">Total:</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($restock->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>