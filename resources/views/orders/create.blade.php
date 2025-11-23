<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Form Pemesanan Baru</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Tambahkan pesanan ikan beku pelanggan Anda</p>
                </div>
                
                <form id="orderForm" method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    
                    <div class="p-6">
                        <!-- Customer Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pelanggan</label>
                                    <label for="walkin_customer" class="inline-flex items-center text-xs sm:text-[0.8rem] text-gray-600 dark:text-gray-400">
                                        <input id="walkin_customer" type="checkbox" class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded mr-2">
                                        <span>Transaksi tanpa data pelanggan</span>
                                    </label>
                                </div>
                                <select name="customer_id" id="customer_id" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Order</label>
                                <input type="text" name="order_number" id="order_number" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" readonly>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Item Pesanan</h4>
                                <button type="button" id="addItemBtn" class="px-3 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white rounded-lg text-sm">+ Tambah Item</button>
                            </div>
                            
                            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm mb-4">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuantitas</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderItemsContainer" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <!-- Items will be added here dynamically -->
                                        <tr id="empty-row">
                                            <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada item pesanan</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-end">
                                <div class="w-1/3 space-y-2">
                                    <div class="flex justify-between py-2">
                                        <span class="font-medium">Subtotal:</span>
                                        <span id="subtotal">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Diskon:</span>
                                        <div class="flex items-center space-x-2">
                                            <select id="discount_type" class="rounded-lg border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-xs">
                                                <option value="nominal">Rp</option>
                                                <option value="percent">%</option>
                                            </select>
                                            <input type="number" id="discount_input" class="w-24 rounded-lg border border-gray-300 bg-white py-1 px-2 text-right text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="0" min="0" step="0.01" value="0">
                                            <span id="discount" class="text-xs text-gray-700 dark:text-gray-200">Rp 0</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="discount_note" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Deskripsi Diskon (opsional)</label>
                                        <input type="text" id="discount_note" class="w-full rounded-lg border border-gray-300 bg-white py-1 px-2 text-xs text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white transition duration-300" placeholder="Misal: Diskon member, promo, dll">
                                    </div>
                                    <div class="flex justify-between py-2 border-t border-gray-300 dark:border-gray-600 mt-1">
                                        <span class="text-lg font-bold">Total:</span>
                                        <span id="total" class="text-lg font-bold text-green-600 dark:text-green-400">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Pembayaran</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Pembayaran</label>
                                    <select name="payment_status" id="payment_status" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                        <option value="belum_dibayar">Belum Dibayar</option>
                                        <option value="dibayar">Dibayar</option>
                                        <option value="gagal">Gagal</option>
                                    </select>
                                </div>
                                
                                <div id="payment_method_container" style="display: none;">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran</label>
                                    <select name="payment_method" id="payment_method" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                        <option value="">Pilih Metode</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                            </div>

                            <div id="cash_payment_container" style="display: none; margin-top: 1rem;">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="received_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Uang Diterima</label>
                                        <input type="number" name="received_amount" id="received_amount" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" step="0.01" min="0">
                                    </div>
                                    
                                    <div>
                                        <label for="change_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kembalian</label>
                                        <input type="number" name="change_amount" id="change_amount" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" step="0.01" min="0" readonly>
                                        <div id="change_display" class="mt-1 text-lg font-bold text-red-600 dark:text-red-400">Rp 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="Catatan tambahan untuk pesanan ini"></textarea>
                        </div>

                        <!-- Order Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Pesanan</label>
                            <select name="status" id="status" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" required>
                                <option value="pending">Belum Bayar</option>
                                <option value="processing">Diproses</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <button type="submit" id="submitBtn" class="px-5 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">Simpan Pesanan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden template for order items -->
    <template id="itemTemplate">
        <tr class="order-item">
            <td class="px-4 py-3">
                <select name="order_items[][product_id]" class="w-full product-select rounded-xl border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </td>
            <td class="px-4 py-3">
                <input type="number" name="order_items[][price]" class="w-full price-input rounded-xl border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" step="0.01" min="0" readonly required>
            </td>
            <td class="px-4 py-3">
                <input type="number" name="order_items[][quantity]" class="w-full quantity-input rounded-xl border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" min="1" value="1" required>
            </td>
            <td class="px-4 py-3">
                <div class="total-item">Rp 0</div>
                <input type="hidden" name="order_items[][total]" class="total-hidden" required>
            </td>
            <td class="px-4 py-3 text-right">
                <button type="button" class="remove-item text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
            </td>
        </tr>
    </template>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75" id="receiptModalBackdrop"></div>
            
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl w-full max-w-md mx-auto">
                <div class="bg-gradient-to-r from-green-50 to-blue-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="text-center">
                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-headline">Transaksi Berhasil!</h3>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Pesanan telah disimpan.</p>
                            <p class="text-sm text-gray-600 mt-1" id="orderNumberDisplay"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button 
                        id="printReceiptBtn"
                        type="button" 
                        class="inline-flex w-full justify-center rounded-xl border border-transparent bg-gradient-to-r from-green-600 to-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">
                        Cetak Struk
                    </button>
                    <button 
                        id="closeReceiptModalBtn"
                        type="button" 
                        class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to parse Indonesian currency format
            function parseCurrency(value) {
                if (typeof value === 'string') {
                    // Remove 'Rp' and other non-numeric characters except comma and dot
                    value = value.replace(/[^0-9,.]/g, '');
                    // Replace dots with nothing and comma with dot for parsing
                    value = value.replace(/\./g, '').replace(',', '.');
                }
                return parseFloat(value) || 0;
            }
            
            // Function to generate order number automatically
            function generateOrderNumber() {
                const date = new Date();
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const random = Math.random().toString(36).substring(2, 6).toUpperCase();
                const sequence = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
                
                return `ORD${year}${month}${day}${sequence}${random}`;
            }
            
            // Function to ensure order number uniqueness (basic implementation)
            function ensureUniqueOrderNumber() {
                // In a real implementation, this would check against the database
                // For now, we rely on the random component to make collisions extremely unlikely
                return generateOrderNumber();
            }
            
            // Generate order number automatically when page loads
            const orderNumberInput = document.getElementById('order_number');
            if (orderNumberInput) {
                orderNumberInput.value = ensureUniqueOrderNumber();
            }
            
            // Form elements
            const paymentStatusSelect = document.getElementById('payment_status');
            const paymentMethodContainer = document.getElementById('payment_method_container');
            const paymentMethodSelect = document.getElementById('payment_method');
            const cashPaymentContainer = document.getElementById('cash_payment_container');
            const receivedAmountInput = document.getElementById('received_amount');
            const changeAmountInput = document.getElementById('change_amount');
            const changeDisplay = document.getElementById('change_display');
            const addItemBtn = document.getElementById('addItemBtn');
            const orderItemsContainer = document.getElementById('orderItemsContainer');
            const itemTemplate = document.getElementById('itemTemplate');
            const subtotalDisplay = document.getElementById('subtotal');
            const totalDisplay = document.getElementById('total');
            const discountInput = document.getElementById('discount_input');
            const discountDisplay = document.getElementById('discount');
            const discountTypeSelect = document.getElementById('discount_type');
            const discountNoteInput = document.getElementById('discount_note');
            const submitBtn = document.getElementById('submitBtn');
            const orderForm = document.getElementById('orderForm');
            const walkinCheckbox = document.getElementById('walkin_customer');
            const customerSelect = document.getElementById('customer_id');
            
            // Modal elements
            const receiptModal = document.getElementById('receiptModal');
            const receiptModalBackdrop = document.getElementById('receiptModalBackdrop');
            const printReceiptBtn = document.getElementById('printReceiptBtn');
            const closeReceiptModalBtn = document.getElementById('closeReceiptModalBtn');
            const orderNumberDisplay = document.getElementById('orderNumberDisplay');
            
            // Function to validate payment amount
            function validatePaymentAmount(total, received) {
                if (received < total && paymentMethodSelect.value === 'cash' && paymentStatusSelect.value === 'dibayar') {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Jumlah Uang Kurang';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Simpan Pesanan';
                }
            }
            
            // Walk-in customer toggle
            if (walkinCheckbox) {
                walkinCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        customerSelect.value = '';
                        customerSelect.disabled = true;
                        customerSelect.classList.add('bg-gray-100', 'dark:bg-gray-800');
                    } else {
                        customerSelect.disabled = false;
                        customerSelect.classList.remove('bg-gray-100', 'dark:bg-gray-800');
                    }
                });
            }

            // Payment status change event
            paymentStatusSelect.addEventListener('change', function() {
                if (this.value === 'dibayar') {
                    paymentMethodContainer.style.display = 'block';
                } else {
                    paymentMethodContainer.style.display = 'none';
                    cashPaymentContainer.style.display = 'none';
                    paymentMethodSelect.value = '';
                }
            });
            
            // Payment method change event
            paymentMethodSelect.addEventListener('change', function() {
                if (this.value === 'cash') {
                    cashPaymentContainer.style.display = 'block';
                } else {
                    cashPaymentContainer.style.display = 'none';
                }
            });
            
            // Received amount change event
            receivedAmountInput.addEventListener('input', function() {
                const totalElement = document.getElementById('total');
                const totalText = totalElement.textContent;
                const total = parseCurrency(totalText);
                const received = parseCurrency(this.value);
                
                // Update change amount
                const change = received - total;
                changeAmountInput.value = change;
                
                // Update change display
                if (change >= 0) {
                    changeDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(change)}`;
                    changeDisplay.className = "mt-1 text-lg font-bold text-green-600 dark:text-green-400";
                } else {
                    changeDisplay.textContent = `Kurang Rp ${new Intl.NumberFormat('id-ID').format(Math.abs(change))}`;
                    changeDisplay.className = "mt-1 text-lg font-bold text-red-600 dark:text-red-400";
                }
                
                // Enable/disable submit button based on validation
                validatePaymentAmount(total, received);
            });
            
            // Function to parse Indonesian currency format
            function parseCurrency(value) {
                if (typeof value === 'string') {
                    // Remove 'Rp' and other non-numeric characters except comma and dot
                    value = value.replace(/[^0-9,.]/g, '');
                    // Replace dots with nothing and comma with dot for parsing
                    value = value.replace(/\./g, '').replace(',', '.');
                }
                return parseFloat(value) || 0;
            }
            
            // Add item button click event
            addItemBtn.addEventListener('click', function() {
                // Remove empty row if exists
                const emptyRow = document.getElementById('empty-row');
                if (emptyRow) {
                    emptyRow.remove();
                }
                
                // Clone template
                const clone = document.importNode(itemTemplate.content, true);
                const row = clone.querySelector('tr');
                
                // Add to container
                orderItemsContainer.appendChild(row);
                
                // Add event listeners to new elements
                const productSelect = row.querySelector('.product-select');
                const priceInput = row.querySelector('.price-input');
                const quantityInput = row.querySelector('.quantity-input');
                const removeBtn = row.querySelector('.remove-item');
                
                productSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    if (price) {
                        priceInput.value = price;
                    } else {
                        priceInput.value = '0';
                    }
                    calculateItemTotal(row);
                    calculateTotal();
                });
                
                priceInput.addEventListener('input', function() {
                    calculateItemTotal(row);
                    calculateTotal();
                });
                
                quantityInput.addEventListener('input', function() {
                    calculateItemTotal(row);
                    calculateTotal();
                });
                
                removeBtn.addEventListener('click', function() {
                    row.remove();
                    calculateTotal();
                    
                    // Show empty row if no items left
                    if (orderItemsContainer.children.length === 0) {
                        orderItemsContainer.innerHTML = '<tr id="empty-row"><td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada item pesanan</td></tr>';
                    }
                });
            });

            // Discount change events
            if (discountInput) {
                discountInput.addEventListener('input', function() {
                    calculateTotal();
                });
            }

            if (discountTypeSelect) {
                discountTypeSelect.addEventListener('change', function() {
                    calculateTotal();
                });
            }
            
            // Function to calculate item total
            function calculateItemTotal(row) {
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const itemTotal = price * quantity;
                
                row.querySelector('.total-item').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(itemTotal)}`;
                row.querySelector('.total-hidden').value = itemTotal;
            }
            
            // Function to calculate total
            function calculateTotal() {
                let subtotal = 0;
                
                document.querySelectorAll('.order-item').forEach(row => {
                    const total = parseFloat(row.querySelector('.total-hidden').value) || 0;
                    subtotal += total;
                });
                
                // Format subtotal for display
                subtotalDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;

                // Handle discount
                const rawDiscount = discountInput ? parseFloat(discountInput.value) || 0 : 0;
                const discountType = discountTypeSelect ? discountTypeSelect.value : 'nominal';
                let effectiveDiscount = 0;

                if (discountType === 'percent') {
                    // rawDiscount as percentage
                    effectiveDiscount = subtotal * (rawDiscount / 100);
                } else {
                    // nominal
                    effectiveDiscount = rawDiscount;
                }

                effectiveDiscount = Math.max(0, Math.min(effectiveDiscount, subtotal));

                if (discountDisplay) {
                    const label = discountType === 'percent'
                        ? `${rawDiscount}% (Rp ${new Intl.NumberFormat('id-ID').format(effectiveDiscount)})`
                        : `Rp ${new Intl.NumberFormat('id-ID').format(effectiveDiscount)}`;
                    discountDisplay.textContent = label;
                }

                const total = subtotal - effectiveDiscount;
                totalDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
                
                // Update change amount if received amount is set
                const received = parseCurrency(receivedAmountInput.value);
                if (received > 0) {
                    const change = received - total;
                    changeAmountInput.value = change;
                    if (change >= 0) {
                        changeDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(change)}`;
                        changeDisplay.className = "mt-1 text-lg font-bold text-green-600 dark:text-green-400";
                    } else {
                        changeDisplay.textContent = `Kurang Rp ${new Intl.NumberFormat('id-ID').format(Math.abs(change))}`;
                        changeDisplay.className = "mt-1 text-lg font-bold text-red-600 dark:text-red-400";
                    }
                    validatePaymentAmount(total, received);
                }
            }
            
            // Form submission
            orderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                const customerId = document.getElementById('customer_id').value;
                const orderNumber = document.getElementById('order_number').value;
                const isWalkin = walkinCheckbox && walkinCheckbox.checked;
                
                if ((!customerId && !isWalkin) || !orderNumber) {
                    alert('Mohon lengkapi semua field yang wajib diisi');
                    return;
                }
                
                // Validate order items
                const orderItems = document.querySelectorAll('.order-item');
                if (orderItems.length === 0) {
                    alert('Harap tambahkan setidaknya satu item pesanan');
                    return;
                }
                
                let hasError = false;
                let errorMessages = [];
                
                // Create a new FormData object
                const formData = new FormData();
                
                // Add basic form data
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                if (!isWalkin && customerId) {
                    formData.append('customer_id', customerId);
                }
                formData.append('order_number', orderNumber);
                formData.append('status', document.getElementById('status').value);
                formData.append('payment_status', document.getElementById('payment_status').value);
                
                const paymentMethod = document.getElementById('payment_method').value;
                if (paymentMethod) {
                    formData.append('payment_method', paymentMethod);
                }
                
                const receivedAmount = document.getElementById('received_amount').value;
                if (receivedAmount) {
                    formData.append('received_amount', receivedAmount);
                }
                
                const notes = document.getElementById('notes').value;
                if (notes) {
                    formData.append('notes', notes);
                }

                // Add discount (numeric) and its meta
                if (discountInput && discountInput.value) {
                    formData.append('discount', discountInput.value);
                }
                if (discountTypeSelect && discountTypeSelect.value) {
                    formData.append('discount_type', discountTypeSelect.value);
                }
                if (discountNoteInput && discountNoteInput.value) {
                    formData.append('discount_note', discountNoteInput.value);
                }
                
                // Add order items with proper indexing
                orderItems.forEach((item, index) => {
                    const productId = item.querySelector('.product-select').value;
                    const quantity = item.querySelector('.quantity-input').value;
                    const price = item.querySelector('.price-input').value;
                    const total = item.querySelector('.total-hidden').value;
                    
                    if (!productId) {
                        hasError = true;
                        errorMessages.push(`Item ${index + 1}: Produk belum dipilih`);
                    }
                    
                    if (!quantity || quantity <= 0) {
                        hasError = true;
                        errorMessages.push(`Item ${index + 1}: Kuantitas harus lebih besar dari 0`);
                    }
                    
                    if (!price || price <= 0) {
                        hasError = true;
                        errorMessages.push(`Item ${index + 1}: Harga harus lebih besar dari 0`);
                    }
                    
                    // Add item to form data with proper indexing
                    formData.append(`order_items[${index}][product_id]`, productId);
                    formData.append(`order_items[${index}][quantity]`, quantity);
                    formData.append(`order_items[${index}][price]`, price);
                });
                
                if (hasError) {
                    alert('Kesalahan validasi:\n' + errorMessages.join('\n'));
                    return;
                }
                
                // Validate payment for cash method
                const paymentMethodSelect = document.getElementById('payment_method');
                const paymentStatusSelect = document.getElementById('payment_status');
                
                if (paymentMethodSelect && paymentStatusSelect && 
                    paymentMethodSelect.value === 'cash' && 
                    paymentStatusSelect.value === 'dibayar') {
                    
                    const totalElement = document.getElementById('total');
                    const totalText = totalElement.textContent;
                    const total = parseCurrency(totalText);
                    const received = parseCurrency(document.getElementById('received_amount').value || '0');
                    
                    if (received < total) {
                        alert('Jumlah uang yang diterima kurang dari total pembayaran');
                        return;
                    }
                }
                
                // Disable submit button to prevent double submission
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Menyimpan...';
                
                // Log form data for debugging
                console.log('Form data being sent:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
                
                // Send AJAX request
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show receipt modal
                        orderNumberDisplay.textContent = `Nomor Order: ${data.order_number}`;
                        receiptModal.classList.remove('hidden');
                        
                        // Set the print receipt button to use the new order ID
                        printReceiptBtn.onclick = function() {
                            window.open('/orders/' + data.order_id + '/receipt', '_blank');
                        };
                        
                        // Close modal and reset form when close button is clicked
                        closeReceiptModalBtn.onclick = function() {
                            receiptModal.classList.add('hidden');
                            orderForm.reset();
                            
                            // Re-enable submit button and restore text
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Simpan Pesanan';
                            
                            // Clear order items container and add empty row
                            orderItemsContainer.innerHTML = '<tr id="empty-row"><td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada item pesanan</td></tr>';
                            
                            // Reset calculations
                            subtotalDisplay.textContent = 'Rp 0';
                            totalDisplay.textContent = 'Rp 0';
                            changeDisplay.textContent = 'Rp 0';
                            cashPaymentContainer.style.display = 'none';
                            paymentMethodContainer.style.display = 'none';
                            orderNumberInput.value = '';
                        };
                    } else {
                        alert('Gagal menyimpan pesanan: ' + (data.message || 'Terjadi kesalahan'));
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Simpan Pesanan';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan pesanan');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Simpan Pesanan';
                });
            });
            
            // Modal backdrop click
            receiptModalBackdrop.addEventListener('click', function() {
                receiptModal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>