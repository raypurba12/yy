<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Supplier Baru') }} 
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8 px-2 sm:px-4 lg:px-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9A6 6 0 116 9v7a1 1 0 001 1h10a1 1 0 001-1V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v4m0 0h4M12 8H8" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white">Formulir Pendaftaran Supplier</h3>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Pastikan semua informasi wajib (*) diisi dengan benar.</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('suppliers.store') }}" class="p-4 sm:p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-4 sm:gap-6">
                        
                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                placeholder="Masukkan nama lengkap supplier" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Jenis Supplier --}}
                        <div>
                            <label for="supplier_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Supplier <span class="text-red-500">*</span></label>
                            <select name="supplier_type" id="supplier_type" 
                                class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm" required>
                                <option value="">Pilih Jenis Supplier</option>
                                @php
                                    // Definisikan array supplierTypes di sini atau pastikan dikirim dari controller
                                    $supplierTypes = [
                                        'local' => 'Lokal',
                                        'import' => 'Impor',
                                        'wholesale' => 'Grosir',
                                        'retail' => 'Eceran',
                                        'specialized' => 'Spesialis',
                                    ];
                                @endphp
                                @foreach($supplierTypes as $type => $label)
                                    <option value="{{ $type }}" {{ old('supplier_type') == $type ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('supplier_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Contoh: Lokal, Impor, Grosir, dll.</p>
                        </div>
                        
                        {{-- Nama Perusahaan --}}
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Perusahaan</label>
                            <input type="text" name="company" id="company" value="{{ old('company') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                placeholder="Masukkan nama perusahaan supplier (misal: PT Ikan Segar Jaya)">
                            @error('company')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                    placeholder="contoh@email.com" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Nomor Telepon --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                    placeholder="Contoh: 081234567890" required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Alamat --}}
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                placeholder="Masukkan alamat lengkap supplier" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            {{-- Kota --}}
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kota <span class="text-red-500">*</span></label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                    placeholder="Masukkan kota supplier" required>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Negara --}}
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Negara <span class="text-red-500">*</span></label>
                                <input type="text" name="country" id="country" value="{{ old('country') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                    placeholder="Masukkan negara supplier" required>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- NPWP Perusahaan --}}
                        <div>
                            <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NPWP Perusahaan</label>
                            <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                placeholder="Masukkan NPWP perusahaan (opsional)">
                            @error('tax_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Catatan --}}
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full rounded-xl border border-gray-300 bg-white py-2.5 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-200 shadow-sm"
                                placeholder="Tambahkan catatan tambahan tentang supplier (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Tombol Aksi --}}
                        <div class="flex flex-col sm:flex-row items-center justify-end mt-6 space-y-3 sm:space-y-0 sm:space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('suppliers.index') }}" class="w-full sm:w-auto text-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white shadow-sm">
                                Batal
                            </a>
                            
                            <button type="submit" class="w-full sm:w-auto text-center px-4 py-2.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Simpan Data</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>