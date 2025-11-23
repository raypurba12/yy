<x-guest-layout>
    <!-- Login Card Content -->
    <div class="relative max-w-xs w-full mx-auto p-1">
        <!-- Header Section -->
        <div class="text-center mb-3">
            <!-- Icon Container -->
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 shadow-md mb-2">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            
            <h2 class="text-base font-bold text-gray-800 mb-0.5">Selamat Datang!</h2>
            <p class="text-xs text-gray-600">Masuk ke akun Anda</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-2" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-2.5">
            @csrf

            <!-- Email Input -->
            <div class="group">
                <x-input-label for="email" :value="__('Email')" class="block text-xs font-semibold text-gray-700 mb-0.5" />
                <div class="relative">
                    <!-- Icon -->
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <!-- Input Field -->
                    <x-text-input 
                        id="email" 
                        class="block w-full pl-8 pr-2 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-300" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="email@contoh.com"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-0.5 text-[0.6rem] text-red-600" />
            </div>

            <!-- Password Input -->
            <div class="group">
                <x-input-label for="password" :value="__('Kata Sandi')" class="block text-xs font-semibold text-gray-700 mb-0.5" />
                <div class="relative">
                    <!-- Icon -->
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <!-- Input Field -->
                    <x-text-input 
                        id="password" 
                        class="block w-full pl-8 pr-2 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-300" 
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-0.5 text-[0.6rem] text-red-600" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-0.5">
                <label class="flex items-center group cursor-pointer">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        class="w-2.5 h-2.5 text-cyan-600 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500 focus:ring-1 transition duration-300 cursor-pointer" 
                        name="remember"
                    >
                    <span class="ml-1.5 text-[0.6rem] text-gray-700">
                        {{ __('Ingat Saya') }}
                    </span>
                </label>
                
                @if (Route::has('password.request'))
                    <a class="text-[0.6rem] font-medium text-cyan-600 hover:text-cyan-700 hover:underline transition-all duration-300" href="{{ route('password.request') }}">
                        {{ __('Lupa Sandi?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="pt-1">
                <x-primary-button class="w-full py-1.5 px-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white text-xs font-semibold rounded-lg shadow transition-all duration-300 transform hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-cyan-500/50 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative my-2.5">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-[0.6rem]">
                <span class="px-2 bg-white text-gray-500">atau</span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-[0.6rem] text-gray-600">
                Belum punya akun?
                <a href="#" class="font-semibold text-cyan-600 hover:text-cyan-700 hover:underline transition-all duration-300">
                    Daftar
                </a>
            </p>
        </div>

        <!-- Footer Info -->
        <div class="mt-2.5 pt-2 border-t border-gray-100 text-center">
            <div class="flex items-center justify-center gap-0.5 mb-1">
                <div class="w-0.5 h-0.5 bg-green-500 rounded-full animate-pulse"></div>
                <p class="text-[0.6rem] text-gray-500">Aman</p>
            </div>
            <p class="text-[0.5rem] text-gray-400">
                &copy; {{ date('Y') }} Sistem Penjualan Ikan Beku
            </p>
        </div>
    </div>
</x-guest-layout>