<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produk Ikan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Daftar Produk Ikan Beku</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">Kelola produk ikan beku Anda dengan mudah dan efisien</p>
                        </div>
                        
                        <!-- Search Form -->
                        <form id="searchForm" class="w-full sm:w-auto">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" 
                                       placeholder="Cari produk..." autocomplete="off">
                                @if(isset($search) && !empty($search))
                                    <button type="button" id="clearSearch" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </form>
                        
                        @if(Auth::user()->hasRole('admin'))
                        <div class="w-full sm:w-auto mt-4 sm:mt-0">
                            <a href="{{ route('products.create') }}" class="px-5 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Produk
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div id="productsTable" class="rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mb-4">
                        @include('products.partials.products-table', ['products' => $products])
                    </div>
                    
                    <!-- Scroll Indicator -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-4 py-1.5 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 text-center flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                            </svg>
                            Geser ke samping untuk melihat lebih banyak data
                            <svg class="w-4 h-4 ml-1 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </p>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div id="paginationContainer" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $products->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const clearSearchBtn = document.getElementById('clearSearch');
            const productsTable = document.getElementById('productsTable');
            const paginationContainer = document.getElementById('paginationContainer');
            
            let searchTimeout;
            
            // Handle search input with debounce
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(performSearch, 500);
                });
            }
            
            // Handle form submission (prevent default and trigger search)
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    performSearch();
                });
            }
            
            // Handle clear search button
            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.focus();
                    performSearch();
                });
            }
            
            // Function to perform the search
            function performSearch() {
                const searchTerm = searchInput ? searchInput.value.trim() : '';
                const url = new URL(window.location.href.split('?')[0]);
                
                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }
                
                // Update browser URL without reloading the page
                window.history.pushState({}, '', url);
                
                // Show loading state
                if (productsTable) {
                    productsTable.innerHTML = `
                        <div class="flex justify-center items-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-cyan-500"></div>
                        </div>
                    `;
                }
                
                // Fetch results via AJAX
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update table and pagination
                    if (productsTable) productsTable.innerHTML = data.table;
                    if (paginationContainer) paginationContainer.innerHTML = data.pagination;
                    
                    // Add fade-in animation to new content
                    if (productsTable) {
                        const rows = productsTable.querySelectorAll('tr');
                        rows.forEach((row, index) => {
                            setTimeout(() => {
                                row.classList.add('animate-fade-in');
                            }, index * 50);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (productsTable) {
                        productsTable.innerHTML = `
                            <div class="p-6 text-center text-red-600 dark:text-red-400">
                                <p>Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>
                            </div>
                        `;
                    }
                });
            }
            
            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const searchParam = urlParams.get('search') || '';
                if (searchInput) searchInput.value = searchParam;
                performSearch();
            });
        });
    </script>
</x-app-layout>