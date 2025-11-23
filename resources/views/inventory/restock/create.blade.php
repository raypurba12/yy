<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pembelian dari Supplier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Form Pembelian dari Supplier</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Tambahkan data pembelian dari supplier baru</p>
                </div>

                <form id="restockForm" method="POST" action="{{ route('restocks.store') }}">
                    @csrf
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Supplier</label>
                                <select name="supplier_id" id="supplier_id" required class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pembelian</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Daftar Item Ikan</h4>
                            <button type="button" id="addItemBtn" class="px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Tambah Item
                            </button>
                        </div>

                        <div id="itemsContainer">
                            <!-- Items will be added here dynamically -->
                            <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="md:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ikan</label>
                                    <select name="restock_items[0][product_id]" class="item-product w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                                        <option value="">Pilih Ikan</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <button type="button" class="remove-item-btn w-full py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Pembelian</label>
                            <input type="text" id="totalAmount" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" readonly value="0">
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
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

                    <div class="p-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                            Simpan Pembelian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter for new item rows
            let itemIndex = 1;
            
            // Add item button event
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const itemRow = document.createElement('div');
                itemRow.className = 'item-row grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl';
                itemRow.innerHTML = `
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ikan</label>
                        <select name="restock_items[${itemIndex}][product_id]" class="item-product w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Pilih Ikan</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Beli (Rp/Kg)</label>
                        <input type="number" name="restock_items[${itemIndex}][price]" class="item-price w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" step="0.01" min="0" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah (Kg)</label>
                        <input type="number" name="restock_items[${itemIndex}][quantity]" class="item-quantity w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" step="0.01" min="0.01" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal</label>
                        <input type="text" class="item-subtotal w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" readonly>
                    </div>
                    
                    <div class="md:col-span-2 flex items-end">
                        <button type="button" class="remove-item-btn w-full py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                            Hapus
                        </button>
                    </div>
                `;
                
                document.getElementById('itemsContainer').appendChild(itemRow);
                itemIndex++;
                
                // Add event listeners to the new inputs
                setupEventListeners(itemRow);
                
                // Add event listener to the new remove button
                itemRow.querySelector('.remove-item-btn').addEventListener('click', function() {
                    itemRow.remove();
                    updateTotal();
                });
            });

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
                    paymentMethodSection.classList.add('hidden');
                    cashPaymentDetails.classList.add('hidden');
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

            // Setup event listeners for initial items
            document.querySelectorAll('.item-row').forEach(setupEventListeners);
            
            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-item-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('.item-row').remove();
                    updateTotal();
                });
            });
        });

        function setupEventListeners(itemRow) {
            const priceInput = itemRow.querySelector('.item-price');
            const quantityInput = itemRow.querySelector('.item-quantity');
            const subtotalInput = itemRow.querySelector('.item-subtotal');
            const productSelect = itemRow.querySelector('.item-product');
            
            // Pre-fill price when product is selected
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption) {
                    const price = selectedOption.getAttribute('data-price');
                    if (price) {
                        priceInput.value = parseFloat(price);
                        calculateSubtotal(priceInput, quantityInput, subtotalInput);
                    }
                }
            });

            // Calculate subtotal when price or quantity changes
            priceInput.addEventListener('input', function() {
                calculateSubtotal(priceInput, quantityInput, subtotalInput);
            });

            quantityInput.addEventListener('input', function() {
                calculateSubtotal(priceInput, quantityInput, subtotalInput);
            });
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
                total += parseFloat(value) || 0;
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