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
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Pembelian dari Suplier</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Analisis pembelian dari suplier</p>
                </div>
                
                <!-- Filter Section -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('reports.purchase-orders') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                            <a href="{{ route('reports.purchase-orders.export') }}{{ request()->has('start_date') || request()->has('end_date') ? '?' . http_build_query(array_filter(['start_date' => request('start_date'), 'end_date' => request('end_date')])) : '' }}" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Cetak Laporan
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Summary Cards -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900 dark:to-blue-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Hari Ini</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($purchaseOrderStats['today'], 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Minggu Ini</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($purchaseOrderStats['thisWeek'], 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900 dark:to-yellow-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Bulan Ini</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($purchaseOrderStats['thisMonth'], 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-purple-100 to-violet-100 dark:from-purple-900 dark:to-violet-900 p-4 rounded-xl">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Tahun Ini</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($purchaseOrderStats['thisYear'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Section -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Grafik Pembelian (30 Hari Terakhir)</h4>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <canvas id="purchaseChart" height="200"></canvas>
                    </div>
                </div>
                
                <!-- Report Table -->
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Detail Pembelian</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Pembelian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rata-rata Harian</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($purchaseOrdersByDate as $data)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">Rp {{ number_format($data->total_amount, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">Rp {{ number_format($data->total_amount / count($purchaseOrdersByDate), 0, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data pembelian untuk periode yang dipilih
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('purchaseChart').getContext('2d');
            
            // Prepare data for the chart
            const dates = @json($purchaseOrdersByDate->pluck('date')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('d M');
            })->values());
            const amounts = @json($purchaseOrdersByDate->pluck('total_amount')->values());
            
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Jumlah Pembelian',
                        data: amounts,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>