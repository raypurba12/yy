<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use App\Models\RestockItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestockController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Restock::class);
        
        $restocks = Restock::with(['supplier', 'user'])->latest()->paginate(10);
        return view('inventory.restock.index', compact('restocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Restock::class);
        
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('inventory.restock.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Restock::class);
        
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'payment_status' => ['required', Rule::in(['belum_dibayar', 'dibayar', 'gagal'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris'])],
            'received_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'restock_items' => 'required|array|min:1',
            'restock_items.*.product_id' => 'required|exists:products,id',
            'restock_items.*.quantity' => 'required|numeric|min:0.01',
            'restock_items.*.price' => 'required|numeric|min:0',
        ]);

        // Generate unique restock number
        $restockNumber = Restock::generateRestockNumber();

        // Create restock items and calculate total amount first
        $totalAmount = 0;
        $changeAmount = null;
        $receivedAmount = $request->received_amount;
        
        if ($request->has('restock_items')) {
            // Reorganize restock items to ensure proper structure
            $restockItems = [];
            $items = $request->input('restock_items', []);
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (is_array($item) && isset($item['product_id']) && isset($item['price']) && isset($item['quantity'])) {
                        $subtotal = $item['quantity'] * $item['price'];
                        $restockItems[] = [
                            'product_id' => $item['product_id'],
                            'price' => $item['price'],
                            'quantity' => $item['quantity'],
                            'subtotal' => $subtotal,
                        ];
                        
                        $totalAmount += $subtotal;
                    }
                }
            }
            
            // Calculate change amount for cash payments
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
            
            // Create the restock first
            $restockData = $request->except('restock_items');
            $restockData['restock_number'] = $restockNumber;
            $restockData['total_amount'] = $totalAmount;
            $restockData['received_amount'] = $receivedAmount;
            $restockData['change_amount'] = $changeAmount;
            $restockData['user_id'] = auth()->id();
            
            $restock = Restock::create($restockData);
            
            // Create restock items
            foreach ($restockItems as $item) {
                $restockItem = RestockItem::create([
                    'restock_id' => $restock->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Update product stock (legacy column)
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                }

                // Also synchronize inventory quantity so listings stay in sync
                $inventory = \App\Models\Inventory::firstOrCreate(
                    ['product_id' => $item['product_id']],
                    [
                        'supplier_id' => $request->supplier_id,
                        'quantity' => 0,
                        'min_stock' => 5,
                        'max_stock' => 1000,
                        'location' => 'Gudang Utama',
                    ]
                );

                // Increase inventory quantity and keep latest supplier info
                $inventory->increment('quantity', $item['quantity']);
                $inventory->update(['supplier_id' => $request->supplier_id]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Pembelian dari supplier berhasil disimpan.',
                'restock_id' => $restock->id,
                'restock_number' => $restockNumber
            ]);
        } else {
            // No restock items provided
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada item pembelian yang disediakan.'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Restock $restock)
    {
        $this->authorize('view', $restock);
        
        $restock->load('supplier', 'user', 'restockItems.product');
        return view('inventory.restock.show', compact('restock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restock $restock)
    {
        $this->authorize('update', $restock);
        
        $suppliers = Supplier::all();
        $products = Product::all();
        $restock->load('restockItems.product');
        return view('inventory.restock.edit', compact('restock', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restock $restock)
    {
        $this->authorize('update', $restock);
        
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'payment_status' => ['required', Rule::in(['belum_dibayar', 'dibayar', 'gagal'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris'])],
            'received_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'restock_items' => 'required|array|min:1',
            'restock_items.*.product_id' => 'required|exists:products,id',
            'restock_items.*.quantity' => 'required|numeric|min:0.01',
            'restock_items.*.price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount first
        $totalAmount = 0;
        $changeAmount = null;
        $receivedAmount = $request->received_amount;
        
        if ($request->has('restock_items')) {
            // Reorganize restock items to ensure proper structure
            $restockItems = [];
            $items = $request->input('restock_items', []);
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (is_array($item) && isset($item['product_id']) && isset($item['price']) && isset($item['quantity'])) {
                        $subtotal = $item['quantity'] * $item['price'];
                        $restockItems[] = [
                            'product_id' => $item['product_id'],
                            'price' => $item['price'],
                            'quantity' => $item['quantity'],
                            'subtotal' => $subtotal,
                        ];
                        
                        $totalAmount += $subtotal;
                    }
                }
            }
            
            // Calculate change amount for cash payments
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
            
            // Update the restock
            $restockData = $request->except('restock_items');
            $restockData['total_amount'] = $totalAmount;
            $restockData['received_amount'] = $receivedAmount;
            $restockData['change_amount'] = $changeAmount;
            
            $restock->update($restockData);

            // Update restock items
            // Delete existing restock items
            $restock->restockItems()->delete();
            
            // Create new restock items and synchronize stock
            foreach ($restockItems as $item) {
                $restockItem = RestockItem::create([
                    'restock_id' => $restock->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Update product stock (legacy column)
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                }

                // Also synchronize inventory quantity
                $inventory = \App\Models\Inventory::firstOrCreate(
                    ['product_id' => $item['product_id']],
                    [
                        'supplier_id' => $request->supplier_id,
                        'quantity' => 0,
                        'min_stock' => 5,
                        'max_stock' => 1000,
                        'location' => 'Gudang Utama',
                    ]
                );

                $inventory->increment('quantity', $item['quantity']);
                $inventory->update(['supplier_id' => $request->supplier_id]);
            }
            
            // Check if request wants JSON response (from AJAX)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pembelian dari supplier berhasil diperbarui.',
                    'restock_id' => $restock->id,
                    'restock_number' => $restock->restock_number
                ]);
            } else {
                return redirect()->route('restocks.index')->with('success', 'Pembelian dari supplier berhasil diperbarui.');
            }
        } else {
            // No restock items provided
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada item pembelian yang disediakan.'
                ], 422);
            } else {
                return redirect()->back()->with('error', 'Tidak ada item pembelian yang disediakan.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restock $restock)
    {
        $this->authorize('delete', $restock);
        
        $restock->delete();

        return redirect()->route('restocks.index')->with('success', 'Pembelian dari supplier berhasil dihapus.');
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
}