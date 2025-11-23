<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Daftar Pelanggan</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">Kelola informasi pelanggan ikan beku Anda</p>
                        </div>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('kasir'))
                        <a href="{{ route('customers.create') }}" class="px-5 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Pelanggan Baru
                            </span>
                        </a>
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
                    
                    <!-- Search Form -->
                    <div class="mb-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="search-input" 
                                class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500" 
                                placeholder="Cari pelanggan..."
                                value="{{ $search ?? '' }}"
                            >
                            <button 
                                id="clear-search" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200"
                                style="display: {{ $search ? 'flex' : 'none' }};"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden mb-4 text-center py-4">
                        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-cyan-600">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memuat...
                        </div>
                    </div>
                    
                    <!-- Customers Table -->
                    <div id="table-container" class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm mb-4">
                        @include('customers.partials.customers-table', ['customers' => $customers])
                    </div>
                    
                    <!-- Pagination -->
                    <div id="pagination-container" class="mt-6">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const clearSearchBtn = document.getElementById('clear-search');
            const tableContainer = document.getElementById('table-container');
            const paginationContainer = document.getElementById('pagination-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            
            let searchTimeout;
            
            // Debounce search input
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();
                
                if (searchTerm.length > 0) {
                    clearSearchBtn.style.display = 'flex';
                } else {
                    clearSearchBtn.style.display = 'none';
                }
                
                // Only search if user has stopped typing for 500ms
                searchTimeout = setTimeout(() => {
                    performSearch(searchTerm);
                }, 500);
                
                // Update URL without page reload
                updateUrl(searchTerm);
            });
            
            // Clear search
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                this.style.display = 'none';
                performSearch('');
                updateUrl('');
            });
            
            // Handle back/forward browser buttons
            window.addEventListener('popstate', function(event) {
                const urlParams = new URLSearchParams(window.location.search);
                const searchTerm = urlParams.get('search') || '';
                searchInput.value = searchTerm;
                clearSearchBtn.style.display = searchTerm ? 'flex' : 'none';
                performSearch(searchTerm, false);
            });
            
            function performSearch(searchTerm, showLoading = true) {
                if (showLoading) {
                    loadingIndicator.classList.remove('hidden');
                    tableContainer.classList.add('opacity-50');
                }
                
                fetch(`{{ route('customers.index') }}?search=${encodeURIComponent(searchTerm)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableContainer.innerHTML = data.table;
                    paginationContainer.innerHTML = data.pagination;
                    
                    // Reinitialize any necessary JavaScript for the new content
                    initializeTooltips();
                    
                    // Scroll to the table with a smooth animation
                    setTimeout(() => {
                        tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    loadingIndicator.classList.add('hidden');
                    tableContainer.classList.remove('opacity-50');
                });
            }
            
            function updateUrl(searchTerm) {
                const url = new URL(window.location);
                
                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }
                
                // Update URL without page reload
                window.history.pushState({}, '', url);
            }
            
            // Initialize any tooltips (if you have any)
            function initializeTooltips() {
                // Initialize any tooltips here if needed
            }
            
            // Initial tooltip initialization
            initializeTooltips();
        });
        
        // Function to handle delete confirmation (if not already defined)
        function openDeleteModal(url, itemName, onSuccess) {
            if (confirm(`Apakah Anda yakin ingin menghapus ${itemName}?`)) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof onSuccess === 'function') {
                            onSuccess();
                        }
                        // Show success message
                        const successMsg = document.createElement('div');
                        successMsg.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4';
                        successMsg.textContent = data.message || 'Data berhasil dihapus.';
                        document.querySelector('.p-6').prepend(successMsg);
                        
                        // Remove the message after 5 seconds
                        setTimeout(() => {
                            successMsg.remove();
                        }, 5000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus data.');
                });
            }
            return false;
        }
        
        // Helper function to remove an element by ID
        function removeElement(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.remove();
            }
        }
    </script>
    @endpush
</x-app-layout>