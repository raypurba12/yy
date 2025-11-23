<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Supplier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Form Edit Supplier</h3>
                    </div>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Edit informasi supplier ikan beku</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan nama lengkap supplier" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="supplier_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Supplier</label>
                                <select name="supplier_type" id="supplier_type" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" required>
                                    <option value="">Pilih Jenis Supplier</option>
                                    @foreach($supplierTypes as $type => $label)
                                        <option value="{{ $type }}" {{ old('supplier_type', $supplier->supplier_type) == $type ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tipe supplier: Lokal, Impor, Grosir, Eceran, atau Spesialis</p>
                            </div>
                            
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Perusahaan</label>
                                <input type="text" name="company" id="company" value="{{ old('company', $supplier->company) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan nama perusahaan supplier">
                                @error('company')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="contoh@email.com" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Contoh: 081234567890" required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat</label>
                                <textarea name="address" id="address" rows="3" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan alamat lengkap supplier" required>{{ old('address', $supplier->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kota</label>
                                    <input type="text" name="city" id="city" value="{{ old('city', $supplier->city) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan kota supplier" required>
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Negara</label>
                                    <input type="text" name="country" id="country" value="{{ old('country', $supplier->country) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan negara supplier" required>
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NPWP Perusahaan</label>
                                <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id', $supplier->tax_id) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan NPWP perusahaan (opsional)">
                                @error('tax_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan</label>
                                <textarea name="notes" id="notes" rows="3" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Tambahkan catatan tambahan tentang supplier (opsional)">{{ old('notes', $supplier->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('suppliers.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                                    Batal
                                </a>
                                
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Perbarui Supplier
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>