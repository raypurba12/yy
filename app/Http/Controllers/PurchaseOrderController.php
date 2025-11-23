<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\InventoryRestockLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'purchaseOrderItems'])->latest()->paginate(10);
        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase-orders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => ['required', Rule::in(['pending', 'processing', 'received', 'delivered', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['belum_dibayar', 'dibayar', 'gagal'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris'])],
            'received_amount' => 'nullable|numeric|min:0',
            'change_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ]);

        // Generate unique purchase number
        $purchaseNumber = $this->generatePurchaseNumber();

        // Create purchase order items and calculate total amount first
        $totalAmount = 0;
        $changeAmount = null;
        $receivedAmount = $request->received_amount;
        
        if ($request->has('order_items')) {
            // Reorganize order items to ensure proper structure
            $orderItems = [];
            $items = $request->input('order_items', []);
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (is_array($item) && isset($item['product_id']) && isset($item['price']) && isset($item['quantity'])) {
                        $orderItems[] = [
                            'product_id' => $item['product_id'],
                            'price' => $item['price'],
                            'quantity' => $item['quantity'],
                        ];
                    }
                }
            }
            
            // Calculate total amount and validate items
            foreach ($orderItems as $item) {
                $itemTotal = $item['quantity'] * $item['price'];
                $totalAmount += $itemTotal;
            }
            
            // Now check if payment is sufficient for cash payments
            if ($request->payment_method === 'cash' && $request->payment_status === 'dibayar') {
                $changeAmount = $receivedAmount - $totalAmount;
                
                // Validate that received amount is sufficient
                if ($changeAmount < 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah uang yang diterima kurang dari total pembayaran.'
                    ], 422);
                }
            }
            
            // Create the purchase order first
            $orderData = $request->except('order_items');
            $orderData['purchase_number'] = $purchaseNumber;
            $orderData['total_amount'] = $totalAmount;
            $orderData['received_amount'] = $receivedAmount;
            $orderData['change_amount'] = $changeAmount;
            
            $purchaseOrder = PurchaseOrder::create($orderData);
            
            // Create purchase order items and update inventory
            foreach ($orderItems as $item) {
                $purchaseOrderItem = PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update inventory quantity per product (single inventory row per product)
                $inventory = Inventory::where('product_id', $item['product_id'])->latest('id')->first();

                if (!$inventory) {
                    // If no inventory exists yet, create one with sensible defaults
                    $inventory = Inventory::create([
                        'product_id' => $item['product_id'],
                        'supplier_id' => $purchaseOrder->supplier_id,
                        'quantity' => 0,
                        'min_stock' => 5,
                        'max_stock' => 1000,
                        'location' => 'Gudang Utama',
                    ]);
                }

                // Only adjust quantity; keep existing min/max/location from inventory
                $inventory->increment('quantity', $item['quantity']);

                // Log restock for reporting/audit
                InventoryRestockLog::create([
                    'inventory_id' => $inventory->id,
                    'supplier_id' => $purchaseOrder->supplier_id,
                    'quantity_added' => $item['quantity'],
                    'date' => now(),
                    'notes' => 'Purchase order ' . $purchaseOrder->purchase_number,
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Purchase order created successfully.',
                'purchase_order_id' => $purchaseOrder->id,
                'purchase_number' => $purchaseNumber
            ]);
        } else {
            // No order items provided
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada item pesanan yang disediakan.'
            ], 422);
        }
    }

    /**
     * Generate unique purchase number.
     */
    private function generatePurchaseNumber()
    {
        $date = date('Ymd');
        $random = strtoupper(bin2hex(random_bytes(2)));
        
        // Get the count of purchase orders for today
        $todayOrders = PurchaseOrder::whereDate('created_at', date('Y-m-d'))->count();
        $sequence = str_pad($todayOrders + 1, 4, '0', STR_PAD_LEFT);
        
        return "PUR{$date}{$sequence}{$random}";
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'purchaseOrderItems.product');
        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseOrder->load('purchaseOrderItems.product');
        return view('purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_number' => 'required|string|unique:purchase_orders,purchase_number,' . $purchaseOrder->id,
            'status' => ['required', Rule::in(['pending', 'processing', 'received', 'delivered', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['belum_dibayar', 'dibayar', 'gagal'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris'])],
            'received_amount' => 'nullable|numeric|min:0',
            'change_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount first
        $totalAmount = 0;
        $changeAmount = null;
        $receivedAmount = $request->received_amount;
        
        if ($request->has('order_items')) {
            // Load existing items to reverse their impact on inventory
            $originalItems = $purchaseOrder->purchaseOrderItems()->get();
            // Reorganize order items to ensure proper structure
            $orderItems = [];
            $items = $request->input('order_items', []);
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (is_array($item) && isset($item['product_id']) && isset($item['price']) && isset($item['quantity'])) {
                        $orderItems[] = [
                            'product_id' => $item['product_id'],
                            'price' => $item['price'],
                            'quantity' => $item['quantity'],
                        ];
                    }
                }
            }
            
            // Calculate total amount and validate items
            foreach ($orderItems as $item) {
                $itemTotal = $item['quantity'] * $item['price'];
                $totalAmount += $itemTotal;
            }
            
            // Now check if payment is sufficient for cash payments
            if ($request->payment_method === 'cash' && $request->payment_status === 'dibayar') {
                $changeAmount = $receivedAmount - $totalAmount;
                
                // Validate that received amount is sufficient
                if ($changeAmount < 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah uang yang diterima kurang dari total pembayaran.'
                    ], 422);
                }
            }
            
            // Update the purchase order
            $orderData = $request->except('order_items');
            $orderData['total_amount'] = $totalAmount;
            $orderData['received_amount'] = $receivedAmount;
            $orderData['change_amount'] = $changeAmount;
            
            $purchaseOrder->update($orderData);

            // Reverse previous inventory quantities for this purchase order
            foreach ($originalItems as $originalItem) {
                // Use the main inventory row for this product (single-row per product)
                $inventory = Inventory::where('product_id', $originalItem->product_id)->latest('id')->first();

                if ($inventory) {
                    $inventory->decrement('quantity', $originalItem->quantity);
                }
            }

            // Delete existing purchase order items
            $purchaseOrder->purchaseOrderItems()->delete();
            
            // Create new purchase order items and apply new quantities to inventory
            foreach ($orderItems as $item) {
                $purchaseOrderItem = PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $inventory = Inventory::firstOrCreate(
                    [
                        'product_id' => $item['product_id'],
                        'supplier_id' => $purchaseOrder->supplier_id,
                    ],
                    [
                        'quantity' => 0,
                        'min_stock' => 0,
                        'max_stock' => 0,
                        'location' => null,
                    ]
                );

                $inventory->increment('quantity', $item['quantity']);

                InventoryRestockLog::create([
                    'inventory_id' => $inventory->id,
                    'supplier_id' => $purchaseOrder->supplier_id,
                    'quantity_added' => $item['quantity'],
                    'date' => now(),
                    'notes' => 'Purchase order updated ' . $purchaseOrder->purchase_number,
                ]);
            }
            
            // Check if request wants JSON response (from AJAX)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Purchase order updated successfully.',
                    'purchase_order_id' => $purchaseOrder->id,
                    'purchase_number' => $purchaseOrder->purchase_number
                ]);
            } else {
                return redirect()->route('purchase-orders.index')->with('success', 'Purchase order updated successfully.');
            }
        } else {
            // No order items provided
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada item pesanan yang disediakan.'
                ], 422);
            } else {
                return redirect()->back()->with('error', 'Tidak ada item pesanan yang disediakan.');
            }
        }
    }

    /**
     * Calculate change amount for cash payments.
     */
    public function calculateChange(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'received_amount' => 'required|numeric|min:0',
        ]);

        $totalAmount = $request->total_amount;
        $receivedAmount = $request->received_amount;
        
        $change = $receivedAmount - $totalAmount;
        
        return response()->json([
            'change' => $change,
            'is_valid' => $change >= 0
        ]);
    }

    /**
     * Display the receipt for the specified purchase order.
     */
    public function printReceipt(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'purchaseOrderItems.product');
        
        return view('purchase-orders.receipt', compact('purchaseOrder'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Reverse inventory quantities for this purchase order before deletion
        $purchaseOrder->load('purchaseOrderItems');

        foreach ($purchaseOrder->purchaseOrderItems as $item) {
            // Use the main inventory row for this product when reversing quantities
            $inventory = Inventory::where('product_id', $item->product_id)->latest('id')->first();

            if ($inventory) {
                $inventory->decrement('quantity', $item->quantity);
            }
        }

        // Delete related items then the purchase order
        $purchaseOrder->purchaseOrderItems()->delete();
        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')->with('success', 'Purchase order deleted successfully.');
    }

    /**
     * Display purchase order reports
     */
    public function reports()
    {
        // Instead of redirecting, call the actual reports method to avoid redirect issues
        $purchaseOrderStats = [
            'today' => \App\Models\PurchaseOrder::whereDate('created_at', today())->sum('total_amount'),
            'thisWeek' => \App\Models\PurchaseOrder::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
            'thisMonth' => \App\Models\PurchaseOrder::whereMonth('created_at', now()->month)->sum('total_amount'),
            'thisYear' => \App\Models\PurchaseOrder::whereYear('created_at', now()->year)->sum('total_amount'),
        ];
        
        $purchaseOrdersByDate = \App\Models\PurchaseOrder::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_amount')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('reports.purchase-orders', compact('purchaseOrderStats', 'purchaseOrdersByDate'));
    }
}