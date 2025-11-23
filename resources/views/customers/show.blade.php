<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pelanggan') }}
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
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Detail Pelanggan: {{ $customer->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Email: {{ $customer->email }}</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white mr-2">
                                Kembali
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}" class="px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-lg shadow transition duration-300">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-3">Informasi Kontak</h4>
                            <div class="space-y-2">
                                <div class="flex">
                                    <span class="text-gray-600 dark:text-gray-400 w-24">Nama:</span>
                                    <span class="text-gray-800 dark:text-white">{{ $customer->name }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 dark:text-gray-400 w-24">Email:</span>
                                    <span class="text-gray-800 dark:text-white">{{ $customer->email }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 dark:text-gray-400 w-24">Telepon:</span>
                                    <span class="text-gray-800 dark:text-white">{{ $customer->phone }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-3">Alamat</h4>
                            <div class="space-y-2">
                                <div class="flex">
                                    <span class="text-gray-600 dark:text-gray-400">Alamat:</span>
                                </div>
                                <div class="text-gray-800 dark:text-white">
                                    {{ $customer->address }}<br>
                                    {{ $customer->city }}, {{ $customer->country }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-3">Ringkasan Pesanan</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                                            {{ $customer->orders->count() }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">Jumlah Pesanan</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                            Rp {{ number_format($customer->orders->sum('total_amount')) }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">Total Pembelian</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">
                                            {{ $customer->orders->where('status', 'delivered')->count() }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">Pesanan Selesai</p>
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