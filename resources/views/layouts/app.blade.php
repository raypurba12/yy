<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FreshFreeze</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Prevent horizontal overflow */
        body, html {
            overflow-x: hidden;
            max-width: 100vw;
        }
        
        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 antialiased">
    <!-- Sidebar Overlay -->
    <div class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300 lg:hidden hidden" id="sidebarOverlay"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 z-50 h-screen w-64 bg-gradient-to-b from-cyan-700 to-blue-700 text-white shadow-2xl flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full" id="sidebar">
            <!-- Logo -->
            <div class="flex items-center gap-3 border-b border-white/10 bg-white/5 p-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo FreshFreeze" class="h-12 w-12 object-cover rounded-2xl flex-shrink-0">
                <span class="text-xl font-bold truncate">FreshFreeze</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
                <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">📊</span>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('users.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('users.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">👤</span>
                    <span class="font-medium text-sm">Manajemen Pengguna</span>
                </a>
                @endif
                
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('kasir'))
                <a href="{{ route('orders.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('orders.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">🛒</span>
                    <span class="font-medium text-sm">Penjualan</span>
                </a>
                @endif

                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('purchase-orders.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('purchase-orders.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">📈</span>
                    <span class="font-medium text-sm">Pembelian Supplier</span>
                </a>
                @endif
                
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('products.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('products.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">🐟</span>
                    <span class="font-medium text-sm">Produk Ikan</span>
                </a>
                
                <a href="{{ route('inventory.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('inventory.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">📦</span>
                    <span class="font-medium text-sm">Stok Gudang</span>
                </a>
                
                <a href="{{ route('suppliers.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('suppliers.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">🚚</span>
                    <span class="font-medium text-sm">Supplier</span>
                </a>
                @endif
                
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('kasir'))
                <a href="{{ route('customers.index') }}" class="nav-link flex items-center gap-3 rounded-xl px-4 py-3 mb-1 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('customers.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                    <span class="text-xl flex-shrink-0">👥</span>
                    <span class="font-medium text-sm">Pelanggan</span>
                </a>
                @endif
                
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('pemilik'))
                <div x-data="{ open: {{ request()->routeIs('reports.*') ? 'true' : 'false' }} }" class="mb-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 rounded-xl px-4 py-3 transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('reports.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-xl flex-shrink-0">📈</span>
                            <span class="font-medium text-sm">Laporan</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200 flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="mt-1 ml-9 space-y-1">
                        <a href="{{ route('reports.sales') }}" target="_blank" class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->routeIs('reports.sales') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                            Laporan Penjualan
                        </a>
                        <a href="{{ route('reports.inventory') }}" target="_blank" class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->routeIs('reports.inventory') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                            Laporan Stok
                        </a>
                        <a href="{{ route('reports.suppliers') }}" target="_blank" class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 {{ request()->routeIs('reports.suppliers') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                            Laporan Supplier
                        </a>
                    </div>
                </div>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200 hover:bg-white/10 text-white/80 hover:text-white">
                        <span class="text-xl flex-shrink-0">🚪</span>
                        <span class="font-medium text-sm">Keluar</span>
                    </button>
                </form>
            </nav>

            <!-- User Info -->
            <div class="border-t border-white/10 bg-white/5 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 to-blue-500 font-bold text-base flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="font-semibold text-sm truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-white/70">
                            @if(Auth::user()->role === 'kasir')
                                Kasir
                            @else
                                {{ ucfirst(Auth::user()->role) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64 min-w-0">
            <!-- Header -->
            <header class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 backdrop-blur-lg dark:border-gray-700 dark:bg-gray-800/90 shadow-sm w-full">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8 max-w-full">
                    <!-- Left Section -->
                    <div class="flex items-center gap-4 flex-1">
                        <button class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" id="menuToggle">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Page Title - Shows on larger screens -->
                        <div class="hidden sm:block">
                            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                                @yield('page-title', 'FreshFreeze')
                            </h1>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                            </span>
                        </button>

                        <!-- User Menu -->
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 font-bold text-white text-sm flex-shrink-0">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left min-w-0">
                                    <div class="font-medium text-sm text-gray-900 dark:text-white truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(Auth::user()->role) }}</div>
                                </div>
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black/5 focus:outline-none" style="display: none;">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                    
                                    <a href="{{ route('profile.edit') }}#settings" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Pengaturan
                                    </a>
                                    
                                    <hr class="my-1 border-gray-200 dark:border-gray-700">
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors">
                                            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 w-full overflow-x-hidden bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800">
                <div class="min-h-full w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-20 right-4 z-[60] space-y-2 w-full max-w-sm pointer-events-none">
        <div class="pointer-events-auto"></div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" id="deleteModalBackdrop"></div>
            
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 shadow-2xl transition-all w-full max-w-md">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 px-6 pt-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300" id="deleteItemName">Anda akan menghapus item ini</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <button id="cancelDeleteBtn" type="button" class="inline-flex justify-center items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-colors">
                        Batal
                    </button>
                    <button id="confirmDeleteBtn" type="button" class="inline-flex justify-center items-center rounded-lg bg-gradient-to-r from-red-600 to-orange-600 px-4 py-2.5 text-sm font-medium text-white hover:from-red-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menuToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden', !sidebar.classList.contains('-translate-x-full'));
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking nav links on mobile
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            });
        });

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }, 100);
        });

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Notification System
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notification-container');
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const icons = {
                success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
                error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
                warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z"></path>',
                info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            };
            
            const notification = document.createElement('div');
            notification.className = `flex items-center p-4 rounded-xl shadow-lg text-white ${colors[type]} transform transition-all duration-300 translate-x-full opacity-0`;
            notification.innerHTML = `
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icons[type]}
                </svg>
                <span class="flex-1 font-medium text-sm">${message}</span>
                <button class="ml-4 flex-shrink-0 hover:opacity-75" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            container.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
            }, 10);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Delete Modal Functions
        function openDeleteModal(url, itemName, callback) {
            document.getElementById('deleteItemName').textContent = itemName;
            window.deleteUrl = url;
            window.deleteCallback = callback;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        
        function confirmDeleteAction() {
            if (window.deleteUrl) {
                handleDeletion(window.deleteUrl, 'DELETE', 'Item berhasil dihapus!', window.deleteCallback);
                closeDeleteModal();
            }
        }
        
        function removeElement(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.remove();
            }
        }

        function handleDeletion(url, method = 'DELETE', message = 'Item berhasil dihapus!', callback = null) {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', method);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {
                // Proses respons JSON
                return response.json().then(data => {
                    if (response.ok) {
                        showNotification(message, 'success');
                        if (callback && typeof callback === 'function') {
                            callback();
                        }
                    } else {
                        const errorMessage = data && data.message ? data.message : 'Terjadi kesalahan saat menghapus item.';
                        showNotification(errorMessage, 'error');
                    }
                });
            })
            .catch(error => {
                showNotification('Terjadi kesalahan saat menghapus item.', 'error');
            });
        }
        
        // Modal event listeners
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
            document.getElementById('deleteModalBackdrop').addEventListener('click', closeDeleteModal);
            document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDeleteAction);
        });
    </script>
</body>
</html>