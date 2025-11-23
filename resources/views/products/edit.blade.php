<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Produk') }}
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
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Form Edit Produk Ikan Beku</h3>
                    </div>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Edit informasi produk ikan beku</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Masukkan nama produk" required>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Deskripsikan produk secara detail">{{ old('description', $product->description) }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga (Rp)</label>
                                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="0" required>
                                </div>
                                
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Berat (Kg)</label>
                                    <input type="number" name="weight" id="weight" step="0.01" value="{{ old('weight', $product->weight) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                    <input type="text" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Contoh: Kg, Ekor" required>
                                </div>
                                
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                                    <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Contoh: Ikan Tuna, Ikan Salmon" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar Produk</label>
                                @if($product->image)
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($product->image) }}" alt="Current Image" class="h-32 w-32 object-cover rounded-lg">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*" class="w-full rounded-xl border border-gray-300 bg-white py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pilih gambar baru jika ingin mengganti gambar produk</p>
                            </div>
                            
                            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                                    Batal
                                </a>
                                
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Perbarui Produk
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