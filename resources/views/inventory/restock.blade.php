<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Restock dari Supplier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Restock Produk dari Supplier</h3>
                    </div>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Tambahkan stok produk dari supplier yang dipilih</p>
                </div>
                
                <div class="p-6">
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h4 class="font-medium text-blue-800 dark:text-blue-200">Detail Produk Saat Ini</h4>
                        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Nama Produk</p>
                                <p class="text-gray-900 dark:text-white">{{ $inventory->product->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Stok Tersedia</p>
                                <p class="text-gray-900 dark:text-white">{{ $inventory->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Supplier Sebelumnya</p>
                                <p class="text-gray-900 dark:text-white">{{ $inventory->supplier->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Lokasi</p>
                                <p class="text-gray-900 dark:text-white">{{ $inventory->location ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <form id="restockForm" method="POST" action="{{ route('inventory.restock', $inventory) }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Supplier</label>
                                <select name="supplier_id" id="supplier_id" required class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $inventory->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }} - {{ $supplier->company ?? 'Perusahaan Tidak Diset' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pembelian</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Items Section -->
                        <div class="mb-6 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Detail Item Ikan</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="md:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ikan</label>
                                    <input type="text" name="restock_items[0][product_name]" value="{{ $inventory->product->name ?? '' }}" readonly class="w-full rounded-xl border border-gray-300 bg-gray-100 py-2 px-3 text-gray-900 dark:border-gray-600 dark:bg-gray-600 dark:text-white">
                                    <input type="hidden" name="restock_items[0][product_id]" value="{{ $inventory->product_id }}">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Beli (Rp/Kg)</label>
                                    <input type="number" name="restock_items[0][price]" class="item-price w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" step="0.01" min="0" required>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah (Kg)</label>
                                    <input type="number" name="restock_items[0][quantity]" class="item-quantity w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" step="0.01" min="0.01" required>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal</label>
                                    <input type="text" class="item-subtotal w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" readonly>
                                </div>
                                
                                <div class="md:col-span-2 flex items-end">
                                    <span class="w-full py-2 text-center bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-white font-medium rounded-xl">Item Utama</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Pembelian</label>
                                <input type="text" id="totalAmount" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" readonly value="0">
                            </div>
                        </div>

                        <!-- Payment Section -->
                        <div class="mb-6 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Pembayaran</label>
                                    <select name="payment_status" id="payment_status" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                                        <option value="belum_dibayar">Belum Dibayar</option>
                                        <option value="dibayar">Dibayar</option>
                                        <option value="gagal">Gagal</option>
                                    </select>
                                </div>

                                <div id="paymentMethodSection" class="hidden">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran</label>
                                    <select name="payment_method" id="payment_method" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Cash Payment Details -->
                            <div id="cashPaymentDetails" class="hidden mt-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="received_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Uang</label>
                                        <input type="number" name="received_amount" id="received_amount" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" step="0.01" min="0">
                                    </div>
                                    
                                    <div>
                                        <label for="change_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kembalian</label>
                                        <input type="text" id="change_amount" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('inventory.index') }}#inventory-{{ $inventory->id }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Simpan Pembelian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup event listeners for initial items
            setupEventListeners(document.querySelector('.item-row') || document.querySelector('.grid.grid-cols-1.md\\:grid-cols-12.gap-4.mb-4'));
            
            // Payment status change event
            document.getElementById('payment_status').addEventListener('change', function() {
                const paymentMethodSection = document.getElementById('paymentMethodSection');
                const cashPaymentDetails = document.getElementById('cashPaymentDetails');
                
                if (this.value === 'dibayar') {
                    paymentMethodSection.classList.remove('hidden');
                    // Check if payment method is cash
                    if (document.getElementById('payment_method').value === 'cash') {
                        cashPaymentDetails.classList.remove('hidden');
                    }
                } else {
                    cashPaymentDetails.classList.add('hidden');
                    paymentMethodSection.classList.add('hidden');
                }
            });

            // Payment method change event
            document.getElementById('payment_method').addEventListener('change', function() {
                const cashPaymentDetails = document.getElementById('cashPaymentDetails');
                
                if (this.value === 'cash') {
                    cashPaymentDetails.classList.remove('hidden');
                } else {
                    cashPaymentDetails.classList.add('hidden');
                }
            });

            // Calculate change when received amount changes
            document.getElementById('received_amount').addEventListener('input', function() {
                const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/\D/g, '')) || 0;
                const receivedAmount = parseFloat(this.value) || 0;
                const change = receivedAmount - totalAmount;
                
                document.getElementById('change_amount').value = change.toLocaleString('id-ID');
            });
            
            // Initial total calculation
            updateTotal();
        });

        function setupEventListeners(itemRow) {
            const priceInput = itemRow.querySelector('.item-price');
            const quantityInput = itemRow.querySelector('.item-quantity');
            const subtotalInput = itemRow.querySelector('.item-subtotal');
            
            // Calculate subtotal when price or quantity changes
            if (priceInput && quantityInput && subtotalInput) {
                priceInput.addEventListener('input', function() {
                    calculateSubtotal(priceInput, quantityInput, subtotalInput);
                });

                quantityInput.addEventListener('input', function() {
                    calculateSubtotal(priceInput, quantityInput, subtotalInput);
                });
            }
        }

        function calculateSubtotal(priceInput, quantityInput, subtotalInput) {
            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseFloat(quantityInput.value) || 0;
            const subtotal = price * quantity;
            
            subtotalInput.value = subtotal.toLocaleString('id-ID');
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.item-subtotal').forEach(function(subtotalInput) {
                const value = subtotalInput.value.replace(/\D/g, '');
                if (value) {
                    total += parseFloat(value) || 0;
                }
            });
            
            document.getElementById('totalAmount').value = total.toLocaleString('id-ID');
            
            // Update change amount if payment status is 'dibayar' and method is 'cash'
            const paymentStatus = document.getElementById('payment_status').value;
            const paymentMethod = document.getElementById('payment_method').value;
            
            if (paymentStatus === 'dibayar' && paymentMethod === 'cash') {
                const receivedAmount = parseFloat(document.getElementById('received_amount').value) || 0;
                const change = receivedAmount - total;
                document.getElementById('change_amount').value = change.toLocaleString('id-ID');
            }
        }
    </script>
</x-app-layout>