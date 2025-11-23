<x-guest-layout>
    <div class="flex flex-col md:flex-row items-center">
        <!-- Left side - Image/Illustration -->
        <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
            <div class="text-center">
                <div class="mx-auto bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/50 dark:to-cyan-900/50 w-32 h-32 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-20 h-20 text-blue-600 dark:text-cyan-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.188 11.538c-.312-.213-.765-.25-1.1-.065a1.13 1.13 0 0 0-.55.83c0 .228.058.451.168.651.212.388.551.69.95.856.22.092.45.14.68.14.23 0 .46-.048.68-.14.22-.092.41-.228.56-.397.15-.17.26-.368.32-.578.06-.21.07-.43.03-.64-.04-.21-.13-.41-.26-.58-.13-.17-.3-.31-.49-.41l-.63-.35c-.21-.12-.44-.2-.68-.24-.24-.04-.49-.03-.73.02-.24.05-.47.14-.67.26-.2.12-.37.28-.5.46-.13.18-.22.39-.26.61-.04.22-.04.44 0 .66.04.22.12.43.24.61.12.18.28.34.46.46.18.12.39.2.61.23.22.03.44.01.65-.05.21-.06.4-.16.56-.29.16-.13.29-.29.39-.47.1-.18.15-.38.16-.59.01-.21-.03-.42-.11-.61zM15.5 10c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5 1.5-.672 1.5-1.5-.672-1.5-1.5-1.5zm-7-2c.276 0 .5.224.5.5s-.224.5-.5.5-.5-.224-.5-.5.224-.5.5-.5zm3 0c.276 0 .5.224.5.5s-.224.5-.5.5-.5-.224-.5-.5.224-.5.5-.5zm3 0c.276 0 .5.224.5.5s-.224.5-.5.5-.5-.224-.5-.5.224-.5.5-.5z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Sistem Penjualan Ikan Beku</h2>
                <p class="text-gray-600 dark:text-gray-300">Kelola penjualan ikan beku Anda dengan mudah dan efisien</p>
            </div>
        </div>
        
        <!-- Right side - Register Form -->
        <div class="md:w-1/2 w-full">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Buat Akun</h1>
                <p class="text-gray-600 dark:text-gray-300">Daftar untuk mengelola sistem penjualan ikan beku</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <x-text-input 
                            id="name" 
                            class="block w-full pl-10 pr-3 py-3 border border-blue-200 dark:border-blue-700 rounded-lg bg-white dark:bg-blue-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            required 
                            autofocus 
                            autocomplete="name" 
                            placeholder="Nama Lengkap"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Email Address -->
                <div class="mt-6">
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <x-text-input 
                            id="email" 
                            class="block w-full pl-10 pr-3 py-3 border border-blue-200 dark:border-blue-700 rounded-lg bg-white dark:bg-blue-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autocomplete="username" 
                            placeholder="email@contoh.com"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Password -->
                <div class="mt-6">
                    <x-input-label for="password" :value="__('Kata Sandi')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <x-text-input 
                            id="password" 
                            class="block w-full pl-10 pr-3 py-3 border border-blue-200 dark:border-blue-700 rounded-lg bg-white dark:bg-blue-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" 
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-6">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <x-text-input 
                            id="password_confirmation" 
                            class="block w-full pl-10 pr-3 py-3 border border-blue-200 dark:border-blue-700 rounded-lg bg-white dark:bg-blue-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" 
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <div class="flex items-center justify-between mt-8">
                    <x-primary-button class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            {{ __('Daftar') }}
                        </span>
                    </x-primary-button>
                </div>
                
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 transition duration-300">
                            Masuk disini
                        </a>
                    </p>
                </div>
                
                <div class="text-center mt-6 pt-4 border-t border-blue-100 dark:border-blue-700/50">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Dengan mendaftar, Anda menyetujui syarat dan ketentuan kami.
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                        &copy; {{ date('Y') }} Sistem Penjualan Ikan Beku. Semua hak dilindungi.
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
