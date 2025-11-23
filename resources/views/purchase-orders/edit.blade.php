<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pembelian dari Suplier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit Pembelian</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Edit pembelian ikan beku dari suplier</p>
                </div>
                
                <form id="purchaseOrderForm" method="POST" action="{{ route('purchase-orders.update', $purchaseOrder) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6">
                        <!-- Supplier Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Suplier</label>
                                <select name="supplier_id" id="supplier_id" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" required>
                                    <option value="">Pilih Suplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $purchaseOrder->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }} - {{ $supplier->phone }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="purchase_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Pembelian</label>
                                <input type="text" name="purchase_number" id="purchase_number" value="{{ old('purchase_number', $purchaseOrder->purchase_number) }}" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" required>
                            </div>
                        </div>

                        <!-- Purchase Items -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Item Pembelian</h4>
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
                                    <tbody id="purchaseItemsContainer" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @if($purchaseOrder->purchaseOrderItems->count() > 0)
                                            @foreach($purchaseOrder->purchaseOrderItems as $purchaseItem)
                                                <tr class="purchase-item">
                                                    <td class="px-4 py-3">
                                                        <select name="order_items[][product_id]" class="w-full product-select rounded-xl border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" required>
                                                            <option value="">Pilih Produk</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" 
                                                                    data-price="{{ $product->price }}" 
                                                                    {{ $purchaseItem->product_id == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <input type="number" name="order_items[][price]" value="{{ $purchaseItem->price }}" class="w-full price-input rounded-xl border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" step="0.01" min="0" required>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <input type="number" name="order_items[][quantity]" value="{{ $purchaseItem->quantity }}" class="w-full quantity-input rounded-xl border border-gray-300 bg-white py-1 px-2 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" min="1" required>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="total-item">Rp {{ number_format($purchaseItem->quantity * $purchaseItem->price, 0, ',', '.') }}</div>
                                                        <input type="hidden" name="order_items[][total]" value="{{ $purchaseItem->quantity * $purchaseItem->price }}" class="total-hidden" required>
                                                    </td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button type="button" class="remove-item text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr id="empty-row">
                                                <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada item pembelian</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-end">
                                <div class="w-1/3">
                                    <div class="flex justify-between py-2">
                                        <span class="font-medium">Subtotal:</span>
                                        <span id="subtotal">Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="font-medium">Diskon:</span>
                                        <span id="discount">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-t border-gray-300 dark:border-gray-600">
                                        <span class="text-lg font-bold">Total:</span>
                                        <span id="total" class="text-lg font-bold text-green-600 dark:text-green-400">Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</span>
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
                                        <option value="belum_dibayar" {{ $purchaseOrder->payment_status == 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                        <option value="dibayar" {{ $purchaseOrder->payment_status == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                                        <option value="gagal" {{ $purchaseOrder->payment_status == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                    </select>
                                </div>
                                
                                <div id="payment_method_container" style="{{ in_array($purchaseOrder->payment_status, ['dibayar']) ? 'display: block;' : 'display: none;' }}">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran</label>
                                    <select name="payment_method" id="payment_method" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                        <option value="">Pilih Metode</option>
                                        <option value="cash" {{ $purchaseOrder->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ $purchaseOrder->payment_method == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="qris" {{ $purchaseOrder->payment_method == 'qris' ? 'selected' : '' }}>QRIS</option>
                                    </select>
                                </div>
                            </div>

                            <div id="cash_payment_container" style="{{ $purchaseOrder->payment_method == 'cash' && $purchaseOrder->payment_status == 'dibayar' ? 'display: block; margin-top: 1rem;' : 'display: none; margin-top: 1rem;' }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="received_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Uang Diterima</label>
                                        <input type="number" name="received_amount" id="received_amount" value="{{ $purchaseOrder->received_amount }}" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" step="0.01" min="0">
                                    </div>
                                    
                                    <div>
                                        <label for="change_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kembalian</label>
                                        <input type="number" name="change_amount" id="change_amount" value="{{ $purchaseOrder->change_amount }}" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="0" step="0.01" min="0" readonly>
                                        <div id="change_display" class="mt-1 text-lg font-bold {{ $purchaseOrder->change_amount >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">Rp {{ number_format(max($purchaseOrder->change_amount, 0), 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="Catatan tambahan untuk pembelian ini">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                        </div>

                        <!-- Purchase Order Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Pembelian</label>
                            <select name="status" id="status" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" required>
                                <option value="pending" {{ $purchaseOrder->status == 'pending' ? 'selected' : '' }}>Baru</option>
                                <option value="processing" {{ $purchaseOrder->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="received" {{ $purchaseOrder->status == 'received' ? 'selected' : '' }}>Diterima</option>
                                <option value="delivered" {{ $purchaseOrder->status == 'delivered' ? 'selected' : '' }}>Dikirim</option>
                                <option value="cancelled" {{ $purchaseOrder->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('purchase-orders.index') }}" class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl shadow-md transition-all duration-300">Batal</a>
                            <button type="submit" id="submitBtn" class="px-5 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">Update Pembelian</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden template for purchase items -->
    <template id="itemTemplate">
        <tr class="purchase-item">
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
            
            // Form elements
            const paymentStatusSelect = document.getElementById('payment_status');
            const paymentMethodContainer = document.getElementById('payment_method_container');
            const paymentMethodSelect = document.getElementById('payment_method');
            const cashPaymentContainer = document.getElementById('cash_payment_container');
            const receivedAmountInput = document.getElementById('received_amount');
            const changeAmountInput = document.getElementById('change_amount');
            const changeDisplay = document.getElementById('change_display');
            const addItemBtn = document.getElementById('addItemBtn');
            const purchaseItemsContainer = document.getElementById('purchaseItemsContainer');
            const itemTemplate = document.getElementById('itemTemplate');
            const subtotalDisplay = document.getElementById('subtotal');
            const totalDisplay = document.getElementById('total');
            const submitBtn = document.getElementById('submitBtn');
            const purchaseOrderForm = document.getElementById('purchaseOrderForm');
            
            // Function to validate payment amount
            function validatePaymentAmount(total, received) {
                if (received < total && paymentMethodSelect.value === 'cash' && paymentStatusSelect.value === 'dibayar') {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Jumlah Uang Kurang';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Update Pembelian';
                }
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
                purchaseItemsContainer.appendChild(row);
                
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
                    if (purchaseItemsContainer.children.length === 0) {
                        purchaseItemsContainer.innerHTML = '<tr id="empty-row"><td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada item pembelian</td></tr>';
                    }
                });
            });
            
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
                
                document.querySelectorAll('.purchase-item').forEach(row => {
                    const total = parseFloat(row.querySelector('.total-hidden').value) || 0;
                    subtotal += total;
                });
                
                // Format subtotal for display
                subtotalDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                totalDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                
                // Update change amount if received amount is set
                const received = parseCurrency(receivedAmountInput.value);
                if (received > 0) {
                    const change = received - subtotal;
                    changeAmountInput.value = change;
                    if (change >= 0) {
                        changeDisplay.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(change)}`;
                        changeDisplay.className = "mt-1 text-lg font-bold text-green-600 dark:text-green-400";
                    } else {
                        changeDisplay.textContent = `Kurang Rp ${new Intl.NumberFormat('id-ID').format(Math.abs(change))}`;
                        changeDisplay.className = "mt-1 text-lg font-bold text-red-600 dark:text-red-400";
                    }
                    validatePaymentAmount(subtotal, received);
                }
            }
            
            // Initialize calculation on page load
            document.querySelectorAll('.purchase-item').forEach(row => {
                calculateItemTotal(row);
            });
            calculateTotal();
            
            // Form submission
            purchaseOrderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                const supplierId = document.getElementById('supplier_id').value;
                const purchaseNumber = document.getElementById('purchase_number').value;
                
                if (!supplierId || !purchaseNumber) {
                    alert('Mohon lengkapi semua field yang wajib diisi');
                    return;
                }
                
                // Validate purchase items
                const purchaseItems = document.querySelectorAll('.purchase-item');
                if (purchaseItems.length === 0) {
                    alert('Harap tambahkan setidaknya satu item pembelian');
                    return;
                }
                
                let hasError = false;
                let errorMessages = [];
                
                // Create a new FormData object
                const formData = new FormData();
                
                // Add basic form data
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('_method', 'PUT');
                formData.append('supplier_id', supplierId);
                formData.append('purchase_number', purchaseNumber);
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
                
                // Add purchase items with proper indexing
                purchaseItems.forEach((item, index) => {
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
                        // Redirect to purchase orders index after success
                        window.location.href = "{{ route('purchase-orders.index') }}";
                    } else {
                        alert('Gagal menyimpan pembelian: ' + (data.message || 'Terjadi kesalahan'));
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Update Pembelian';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan pembelian');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Update Pembelian';
                });
            });
        });
    </script>
</x-app-layout>