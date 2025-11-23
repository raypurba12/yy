<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Supplier') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-md sm:shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    
                    {{-- HEADER SECTION --}}
                    <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="mb-2 sm:mb-0">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white mb-1 flex items-center">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 mr-2 sm:mr-3 text-cyan-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="truncate">Daftar Supplier</span>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">Kelola informasi supplier ikan beku Anda</p>
                        </div>
                        
                        <div class="flex flex-col xs:flex-row space-y-2 xs:space-y-0 xs:space-x-2 w-full sm:w-auto">
                            {{-- Enhanced Search Form --}}
                            <div class="relative w-full xs:w-48 sm:w-60 md:w-72">
                                <form id="searchForm" class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           id="searchInput" 
                                           value="{{ $search ?? '' }}" 
                                           class="block w-full pl-9 pr-8 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg sm:rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-xs sm:text-sm transition-all duration-200" 
                                           placeholder="Cari..." 
                                           autocomplete="off"
                                           aria-label="Cari supplier"
                                           aria-describedby="searchHelp"
                                           spellcheck="false"
                                           autocorrect="off"
                                           autocapitalize="off">
                                    
                                    @if(isset($search) && !empty($search))
                                        <button type="button" 
                                                id="clearSearch" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200"
                                                aria-label="Hapus pencarian">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @else
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <kbd class="px-1.5 py-0.5 text-xs font-semibold text-gray-400 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700">/</kbd>
                                        </div>
                                    @endif
                                    
                                    <div id="searchLoading" class="absolute inset-y-0 right-0 pr-10 flex items-center pointer-events-none hidden">
                                        <svg class="animate-spin h-4 w-4 text-cyan-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </form>
                                
                                {{-- Search suggestions dropdown --}}
                                <div id="searchSuggestions" class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div class="py-1">
                                        <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">Pencarian terakhir</div>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>PT. Sejahtera Abadi</span>
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Ikan Segar Makmur</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <div id="searchHelp" class="mt-1 text-xs text-gray-500 dark:text-gray-400 hidden">
                                    Tekan <kbd class="px-1 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-xs">Enter</kbd> untuk mencari
                                </div>
                            </div>
                            
                            {{-- Add Button --}}
                            @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('suppliers.create') }}" class="group relative w-full xs:w-auto flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2.5 overflow-hidden font-medium sm:font-bold text-white rounded-lg shadow-sm sm:shadow-md bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 transform transition-all duration-200 hover:scale-[1.02] hover:shadow-md sm:hover:shadow-xl text-xs sm:text-sm">
                                <span class="relative flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Supplier
                                </span>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- ALERT MESSAGES --}}
                    @if(session('success'))
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg mb-6 shadow-md flex items-center animate-fade-in">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 px-6 py-4 rounded-lg mb-6 shadow-md flex items-center animate-fade-in">
                            <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- TABLE CONTAINER --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                        <div class="overflow-x-auto rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm -mx-2 sm:mx-0">
                            <div class="inline-block min-w-full align-middle">
                                @include('suppliers.partials.suppliers-table', ['suppliers' => $suppliers])
                            </div>
                        </div>
                        
                        @if($suppliers->isEmpty())
                            <div class="p-10 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h4m1-1v-4a2 2 0 012-2h4a2 2 0 012 2v4m-5 4h.01M17 19h2a2 2 0 002-2v-3"/>
                                </svg>
                                <p class="text-lg font-medium">Tidak ada supplier yang ditemukan.</p>
                                <p class="text-sm mt-1">Coba sesuaikan pencarian Anda atau tambahkan supplier baru.</p>
                            </div>
                        @endif
                    </div>

                        </div>
                    </div>
                    
                    {{-- Pagination --}}
                    @if(isset($suppliers) && $suppliers->hasPages())
                    <div class="px-3 sm:px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <div class="flex flex-col xs:flex-row items-center justify-between space-y-2 xs:space-y-0">
                            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan {{ $suppliers->firstItem() }} - {{ $suppliers->lastItem() }} dari {{ $suppliers->total() }} supplier
                            </div>
                            <div class="pagination">
                                {{ $suppliers->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ENHANCED STYLES --}}
    <style>
        /* Responsive Table */
        @media (max-width: 767px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-responsive > table {
                min-width: 600px;
            }
            
            .pagination .flex {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .pagination .hidden {
                display: none;
            }
            
            .pagination .space-x-1 > * + * {
                margin-left: 0.25rem;
            }
            
            .pagination .p-1 {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Utility Classes */
        .animate-fade-in { 
            animation: fadeIn 0.3s ease-out forwards; 
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Scrollbar Styling */
        .scrollbar-custom { 
            scrollbar-width: thin; 
            scrollbar-color: #06b6d4 #f1f5f9;
            -webkit-overflow-scrolling: touch;
        }
        
        .scrollbar-custom::-webkit-scrollbar { 
            height: 8px; 
            width: 8px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-track { 
            background: #f1f5f9; 
            border-radius: 10px; 
            margin: 4px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-thumb { 
            background: linear-gradient(to right, #06b6d4, #3b82f6); 
            border-radius: 10px; 
            border: 2px solid #f1f5f9; 
        }
        
        .dark .scrollbar-custom { 
            scrollbar-color: #06b6d4 #1f2937; 
        }
        
        .dark .scrollbar-custom::-webkit-scrollbar-track { 
            background: #1f2937; 
            border-color: #374151;
        }
        
        .dark .scrollbar-custom::-webkit-scrollbar-thumb { 
            background: linear-gradient(to right, #0891b2, #2563eb); 
            border-color: #1f2937; 
        }
        
        /* Search Input Focus State */
        #searchInput:focus {
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.2);
        }
        
        /* Dark mode transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        .dark .skeleton {
            background: linear-gradient(90deg, #1f2937 25%, #374151 50%, #1f2937 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .scrollbar-custom {
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none; /* Firefox */
            }
            .scrollbar-custom::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }
        }
    </style>
    
    {{-- JAVASCRIPT FOR AJAX SEARCH --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const clearSearchBtn = document.getElementById('clearSearch');
            const suppliersTableContainer = document.getElementById('suppliersTableContainer');
            const paginationContainer = document.getElementById('paginationContainer');
            
            let searchTimeout;
            
            function attachPaginationListeners() {
                paginationContainer.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        performSearch(e.target.href);
                    });
                });
            }
            
            // Handle pagination links on first load
            attachPaginationListeners();

            // Handle search input with debounce and instant feedback
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                const searchLoading = document.getElementById('searchLoading');
                
                // Show loading indicator after typing stops for 200ms
                clearTimeout(searchTimeout);
                searchLoading.classList.add('hidden');
                
                // Show help text when user starts typing
                const searchHelp = document.getElementById('searchHelp');
                if (query.length > 0) {
                    searchHelp.classList.remove('hidden');
                } else {
                    searchHelp.classList.add('hidden');
                }
                
                // Only search after user stops typing for 500ms
                searchTimeout = setTimeout(() => {
                    if (query.length > 0) {
                        searchLoading.classList.remove('hidden');
                    }
                    performSearch(window.location.href.split('?')[0]);
                }, 500);
                
                // Show/hide clear button
                const clearSearchBtn = document.getElementById('clearSearch');
                if (clearSearchBtn) {
                    clearSearchBtn.style.display = query.length > 0 ? 'flex' : 'none';
                }
                
                // Show suggestions if input is not empty
                const searchSuggestions = document.getElementById('searchSuggestions');
                if (searchSuggestions) {
                    searchSuggestions.classList.toggle('hidden', query.length === 0);
                }
            });
            
            // Handle form submission (prevent default and trigger search)
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(searchTimeout);
                performSearch(window.location.href.split('?')[0]);
                // Hide keyboard on mobile after search
                searchInput.blur();
            });
            
            // Handle keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Focus search input when / is pressed
                if (e.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                    e.preventDefault();
                    searchInput.focus();
                }
                // Clear search when Escape is pressed
                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                    searchInput.blur();
                }
            });    
            
            // Handle clear search button
            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.focus();
                    performSearch(window.location.href.split('?')[0]);
                });
            }
            
            // Function to perform the search with better error handling and loading states
            function performSearch(baseUrl) {
                const searchTerm = searchInput.value.trim();
                const url = new URL(baseUrl);
                const searchLoading = document.getElementById('searchLoading');
                
                // Construct query parameters
                const currentParams = new URLSearchParams(window.location.search);
                currentParams.forEach((value, key) => {
                    if (key !== 'search' && key !== 'page') {
                        url.searchParams.set(key, value);
                    }
                });

                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                    url.searchParams.delete('page');
                }
                
                // Don't make a request if we're already on this URL
                if (window.location.href.split('?')[0] === url.toString().split('?')[0] && 
                    new URLSearchParams(window.location.search).get('search') === url.searchParams.get('search')) {
                    searchLoading.classList.add('hidden');
                    return;
                }
                
                // Update browser URL without reload
                window.history.pushState({}, '', url);
                
                // Show loading state with skeleton loader
                if (suppliersTableContainer.querySelector('table')) {
                    const rows = suppliersTableContainer.querySelectorAll('tbody tr');
                    if (rows.length > 0) {
                        const skeletonHtml = `
                            <div class="animate-pulse space-y-4 p-4">
                                ${Array.from({length: Math.min(5, rows.length)}).map(() => `
                                    <div class="h-16 bg-gray-100 dark:bg-gray-700 rounded-lg"></div>
                                `).join('')}
                            </div>
                        `;
                        suppliersTableContainer.innerHTML = skeletonHtml;
                    } else {
                        suppliersTableContainer.innerHTML = `
                            <div class="flex flex-col justify-center items-center py-16 text-cyan-500 dark:text-cyan-400">
                                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-cyan-500 mb-3"></div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Mencari data...</p>
                            </div>
                    }
                });    
                
                // Handle clear search button
                if (clearSearchBtn) {
                    clearSearchBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        searchInput.focus();
                        performSearch(window.location.href.split('?')[0]);
                    });
                }
                
                // Function to perform the search with better error handling and loading states
                function performSearch(baseUrl) {
                    const searchTerm = searchInput.value.trim();
                    const url = new URL(baseUrl);
                    const searchLoading = document.getElementById('searchLoading');
                    
                    if (searchTerm) {
                        url.searchParams.set('search', searchTerm);
                    } else {
                        url.searchParams.delete('search');
                    }
                    
                    // Show loading indicator
                    searchLoading.classList.remove('hidden');
                    
                    // Update URL without page reload
                    window.history.pushState({}, '', url.toString());
                    
                    // Store the timestamp of this search
                    const searchTimestamp = Date.now();
                    window.lastSearchTimestamp = searchTimestamp;
                    
                    // Show loading state
                    suppliersTableContainer.classList.add('opacity-50', 'pointer-events-none');
                    
                    // Fetch data from server
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html, */*; q=0.01'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Check if this is still the most recent search
                        if (searchTimestamp !== window.lastSearchTimestamp) {
                            return;
                        }
                        
                        // Replace the table content
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('suppliersTableContainer');
                        
                        if (newTable) {
                            suppliersTableContainer.innerHTML = newTable.innerHTML;
                            attachPaginationListeners();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Hide loading indicator
                        searchLoading.classList.add('hidden');
                        suppliersTableContainer.classList.remove('opacity-50', 'pointer-events-none');
                    });
                    
                    // Hide suggestions after search
                    const searchSuggestions = document.getElementById('searchSuggestions');
                    if (searchSuggestions) {
                        searchSuggestions.classList.add('hidden');
                    }
                }
                
                // Handle browser back/forward buttons
                window.addEventListener('popstate', function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const searchParam = urlParams.get('search') || '';
                    searchInput.value = searchParam;
                    performSearch(window.location.href); 
                .catch(error => {
                    console.error('Error fetching data:', error);
                    
                    // Only show error if this is still the most recent search
                    if (searchTimestamp === window.lastSearchTimestamp) {
                        suppliersTableContainer.innerHTML = `
                            <div class="p-8 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Gagal memuat data</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">${error.message || 'Terjadi kesalahan saat memuat data. Silakan coba lagi.'}</p>
                                <button onclick="window.location.reload()" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors text-sm font-medium">
                                    Muat Ulang Halaman
                                </button>
                            </div>
                        `;
                    }
                })
                .finally(() => {
                    clearTimeout(searchDelay);
                    searchLoading.classList.add('hidden');
                });
            }
            
            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const searchParam = urlParams.get('search') || '';
                searchInput.value = searchParam;
                performSearch(window.location.href); 
            });
        });
    </script>
</x-app-layout>