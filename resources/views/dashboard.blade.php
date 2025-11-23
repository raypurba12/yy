<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mt-1">Selamat datang kembali! Berikut ringkasan bisnis Anda hari ini.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
        <!-- Stock Notifications -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
            <!-- Low Stock Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Stok Menipis</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2" data-stat="lowStockProducts">{{ number_format($lowStockProducts ?? 0) }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Out of Stock Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Stok Habis</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2" data-stat="outOfStockProducts">{{ number_format($outOfStockProducts ?? 0) }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <!-- Total Products -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2" data-stat="totalProducts">{{ number_format($totalProducts) }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                        ↑ 12%
                    </span>
                    <span class="ml-2 text-gray-500 dark:text-gray-400">vs bulan lalu</span>
                </div>
            </div>

            <!-- Sales Today -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Penjualan Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2" data-stat="totalOrdersToday">{{ number_format($totalOrdersToday) }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                        ↑ 8%
                    </span>
                    <span class="ml-2 text-gray-500 dark:text-gray-400">vs kemarin</span>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border-l-4 border-amber-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pendapatan</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2" data-stat="totalRevenue">Rp {{ number_format($totalRevenue / 1000000, 1) }}M</p>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                        ↑ 23%
                    </span>
                    <span class="ml-2 text-gray-500 dark:text-gray-400">vs bulan ini</span>
                </div>
            </div>

            <!-- Active Customers -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pelanggan Aktif</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2" data-stat="totalCustomers">{{ number_format($totalCustomers) }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                        ↑ 5%
                    </span>
                    <span class="ml-2 text-gray-500 dark:text-gray-400">vs bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <!-- Sales Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-2">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Grafik Penjualan Minggu Ini</h3>
                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 w-fit">
                        Minggu Ini
                    </span>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Product Distribution Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-2">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Distribusi Produk</h3>
                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 w-fit">
                        Total: {{ array_sum($productDistribution['data']) }} Produk
                    </span>
                </div>
                <div class="flex flex-col lg:flex-row items-center gap-6">
                    <div class="w-full lg:w-2/3 relative" style="height: 250px;">
                        <canvas id="productChart"></canvas>
                    </div>
                    <div id="productChartLegend" class="w-full lg:w-1/3 space-y-2"></div>
                </div>
            </div>
        </div>

        <!-- Recent Orders and Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <!-- Recent Orders -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Penjualan Terbaru</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                        Lihat semua →
                    </a>
                </div>
                <div class="space-y-3" data-section="recentOrders">
                    @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 dark:text-gray-200 truncate">#{{ $order->id ?: $order->order_number }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $order->customer->name ?? 'Pelanggan Umum' }}</p>
                        </div>
                        <div class="flex-shrink-0 ml-4 text-right">
                            <p class="font-semibold text-gray-800 dark:text-gray-200 whitespace-nowrap">Rp {{ number_format($order->total_amount) }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_bg_color }} text-{{ $order->status_text_color }} dark:bg-{{ $order->status_bg_dark_color }} dark:text-{{ $order->status_text_dark_color }} mt-1">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada pesanan hari ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Produk Terlaris</h3>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                        Lihat semua →
                    </a>
                </div>
                <div class="space-y-4" data-section="topProducts">
                    @forelse($topProducts as $index => $product)
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-{{ $product->color_class }} text-{{ $product->text_color_class }} flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->weight ?? 'N/A' }} {{ $product->unit ?? '' }}</p>
                        </div>
                        <div class="flex-shrink-0 ml-4 text-right">
                            <p class="font-semibold text-gray-800 dark:text-gray-200 whitespace-nowrap">{{ $product->orders_sum_quantity ?? 0 }} terjual</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Rp {{ number_format($product->price ?? 0) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada data produk terlaris</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Charts and Real-time Updates -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                const ctx = salesCtx.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(2, 128, 144, 0.3)');
                gradient.addColorStop(1, 'rgba(2, 128, 144, 0.05)');
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($salesData['labels']),
                        datasets: [{
                            label: 'Total Penjualan',
                            data: @json($salesData['data']),
                            borderColor: '#028090',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#028090',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                                titleColor: '#F9FAFB',
                                bodyColor: '#E5E7EB',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return `Rp ${(context.raw * 1000000).toLocaleString('id-ID')}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6B7280',
                                    font: { size: 11 },
                                    callback: function(value) {
                                        return 'Rp ' + value + 'jt';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6B7280',
                                    font: { size: 11 }
                                }
                            }
                        }
                    }
                });
            }

            // Product Distribution Chart
            const productCtx = document.getElementById('productChart');
            if (productCtx) {
                const labels = @json($productDistribution['labels'] ?? []);
                const data = @json($productDistribution['data'] ?? []);
                const colors = ['#028090', '#00b4d8', '#48cae4', '#90e0ef', '#caf0f8'];
                
                new Chart(productCtx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: colors,
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                                padding: 12,
                                cornerRadius: 8
                            }
                        }
                    }
                });

                // Generate legend
                const legendContainer = document.getElementById('productChartLegend');
                if (legendContainer) {
                    const total = data.reduce((a, b) => a + b, 0);
                    legendContainer.innerHTML = labels.map((label, i) => {
                        const value = data[i] || 0;
                        const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                        return `
                            <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center min-w-0 flex-1">
                                    <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: ${colors[i % colors.length]}"></span>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 ml-2 truncate">${label}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 ml-2">${percentage}%</span>
                            </div>
                        `;
                    }).join('');
                }
            }

            // Real-time updates
            function updateDashboard() {
                fetch('/dashboard/data')
                    .then(response => response.json())
                    .then(data => {
                        // Update stats
                        const stats = {
                            totalProducts: data.totalProducts,
                            totalOrdersToday: data.totalOrdersToday,
                            totalRevenue: 'Rp ' + (data.totalRevenue / 1000000).toFixed(1) + 'M',
                            totalCustomers: data.totalCustomers,
                            lowStockProducts: data.lowStockProducts,
                            outOfStockProducts: data.outOfStockProducts
                        };

                        Object.keys(stats).forEach(key => {
                            const element = document.querySelector(`[data-stat="${key}"]`);
                            if (element) {
                                element.textContent = typeof stats[key] === 'number' ? stats[key].toLocaleString() : stats[key];
                            }
                        });
                    })
                    .catch(error => console.error('Error updating dashboard:', error));
            }
            
            // Update every 30 seconds
            setInterval(updateDashboard, 30000);
            window.addEventListener('focus', updateDashboard);
        });
    </script>
</x-app-layout>