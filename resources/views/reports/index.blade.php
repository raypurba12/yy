<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan dan Analitik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-t-2xl p-6 mb-6 shadow-lg">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Laporan dan Analitik</h1>
                        <p class="text-blue-100">Sistem Penjualan Ikan Beku - Ringkasan dan Analisis Data</p>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Total Pesanan</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalOrders) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Total Pembelian</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalPurchaseOrders) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 dark:bg-yellow-900/30 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Jenis Laporan Tersedia
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Pilih jenis laporan yang ingin Anda lihat atau cetak</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Sales Report -->
                        <a href="{{ route('reports.sales') }}" class="group block bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border border-blue-200 dark:border-blue-700 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-800/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">Laporan Penjualan</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Analisis penjualan harian, mingguan, bulanan</p>
                                    <div class="mt-3 flex items-center text-sm text-blue-600 dark:text-blue-400 font-medium">
                                        <span>Lihat Detail</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Inventory Report -->
                        <a href="{{ route('reports.inventory') }}" class="group block bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-800/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors">Laporan Stok</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Status stok produk dan peringatan rendah</p>
                                    <div class="mt-3 flex items-center text-sm text-green-600 dark:text-green-400 font-medium">
                                        <span>Lihat Detail</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Customer Report -->
                        <a href="{{ route('reports.customers') }}" class="group block bg-gradient-to-br from-purple-50 to-fuchsia-50 dark:from-purple-900/20 dark:to-fuchsia-900/20 border border-purple-200 dark:border-purple-700 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-purple-100 dark:bg-purple-800/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-700 dark:group-hover:text-purple-300 transition-colors">Laporan Pelanggan</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Analisis pelanggan dan preferensi</p>
                                    <div class="mt-3 flex items-center text-sm text-purple-600 dark:text-purple-400 font-medium">
                                        <span>Lihat Detail</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Purchase Orders Report -->
                        <a href="{{ route('reports.purchase-orders') }}" class="group block bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-amber-100 dark:bg-amber-800/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-amber-700 dark:group-hover:text-amber-300 transition-colors">Laporan Pembelian dari Suplier</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Analisis pembelian dari suplier</p>
                                    <div class="mt-3 flex items-center text-sm text-amber-600 dark:text-amber-400 font-medium">
                                        <span>Lihat Detail</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Sales PDF Download -->
                        <a href="{{ route('reports.export', ['type' => 'sales']) }}" class="group block bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-800/30 dark:to-cyan-800/30 border border-blue-300 dark:border-blue-600 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-blue-200 dark:bg-blue-700/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-blue-700 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">Cetak Laporan Penjualan</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Unduh PDF laporan penjualan</p>
                                    <div class="mt-3 flex items-center text-sm text-blue-600 dark:text-blue-400 font-medium">
                                        <span>Download PDF</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Inventory PDF Download -->
                        <a href="{{ route('reports.export', ['type' => 'inventory']) }}" class="group block bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-800/30 dark:to-emerald-800/30 border border-green-300 dark:border-green-600 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-green-200 dark:bg-green-700/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-green-700 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors">Cetak Laporan Stok</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Unduh PDF laporan stok</p>
                                    <div class="mt-3 flex items-center text-sm text-green-600 dark:text-green-400 font-medium">
                                        <span>Download PDF</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Customer PDF Download -->
                        <a href="{{ route('reports.export', ['type' => 'customers']) }}" class="group block bg-gradient-to-br from-purple-100 to-fuchsia-100 dark:from-purple-800/30 dark:to-fuchsia-800/30 border border-purple-300 dark:border-purple-600 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="bg-purple-200 dark:bg-purple-700/30 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-purple-700 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-700 dark:group-hover:text-purple-300 transition-colors">Cetak Laporan Pelanggan</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Unduh PDF laporan pelanggan</p>
                                    <div class="mt-3 flex items-center text-sm text-purple-600 dark:text-purple-400 font-medium">
                                        <span>Download PDF</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>