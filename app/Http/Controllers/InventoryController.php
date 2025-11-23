<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::with(['product', 'supplier']);

        // Search by product or supplier name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('supplier', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by stock status
        if ($request->filled('status')) {
            $status = $request->input('status');

            $query->where(function ($q) use ($status) {
                if ($status === 'low') {
                    // Stok rendah: > 0 dan <= min_stock
                    $q->where('quantity', '>', 0)
                      ->whereColumn('quantity', '<=', 'min_stock');
                } elseif ($status === 'out') {
                    // Habis: quantity = 0
                    $q->where('quantity', 0);
                } elseif ($status === 'available') {
                    // Tersedia: di atas min_stock tapi belum mencapai max_stock
                    $q->whereColumn('quantity', '>', 'min_stock')
                      ->whereColumn('quantity', '<', 'max_stock');
                } elseif ($status === 'full') {
                    // Stok penuh atau di atas max_stock
                    $q->whereColumn('quantity', '>=', 'max_stock');
                }
            });
        }

        $inventories = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only show products that do not yet have an inventory record
        $products = Product::doesntHave('inventory')->get();
        $suppliers = Supplier::all();
        return view('inventory.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:inventories,product_id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Inventory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        $inventory->load('product', 'supplier');
        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('inventory.edit', compact('inventory', 'products', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
    }

    /**
     * Show the form for restocking from supplier.
     */
    public function restockForm(Inventory $inventory)
    {
        $suppliers = Supplier::all();
        return view('inventory.restock', compact('inventory', 'suppliers'));
    }

    /**
     * Restock inventory from supplier.
     */
    public function restock(Request $request, Inventory $inventory)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'payment_status' => ['required', 'in:belum_dibayar,dibayar,gagal'],
            'payment_method' => ['nullable', 'in:cash,transfer,qris'],
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
                    return redirect()->back()->withErrors(['received_amount' => 'Jumlah uang yang diterima kurang dari total pembayaran.']);
                }
            }
            
            // Generate unique restock number
            $restockNumber = \App\Models\Restock::generateRestockNumber();

            // Create the restock
            $restockData = $request->except('restock_items');
            $restockData['restock_number'] = $restockNumber;
            $restockData['total_amount'] = $totalAmount;
            $restockData['received_amount'] = $receivedAmount;
            $restockData['change_amount'] = $changeAmount;
            $restockData['user_id'] = auth()->id();
            
            $restock = \App\Models\Restock::create($restockData);
            
            // Create restock items and update inventory
            foreach ($restockItems as $item) {
                $restockItem = \App\Models\RestockItem::create([
                    'restock_id' => $restock->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Update product stock
                $product = \App\Models\Product::find($item['product_id']);
                $product->increment('stock', $item['quantity']);
                
                // If this is restocking the specific inventory item, update the quantity
                if ($item['product_id'] == $inventory->product_id) {
                    $newQuantity = $inventory->quantity + $item['quantity'];
                    $inventory->update([
                        'supplier_id' => $request->supplier_id,
                        'quantity' => $newQuantity,
                        'location' => $request->location ?? $inventory->location
                    ]);
                    
                    // Create a log entry for the restock
                    \App\Models\InventoryRestockLog::create([
                        'inventory_id' => $inventory->id,
                        'supplier_id' => $request->supplier_id,
                        'quantity_added' => $item['quantity'],
                        'notes' => $request->notes, // Simpan notes jika ada
                        'date' => $request->purchase_date,
                    ]);
                }
            }
            
            return redirect()->route('inventory.index')->with('success', 'Pembelian dari supplier berhasil disimpan dan stok telah diperbarui.');
        } else {
            // No restock items provided
            return redirect()->back()->withErrors(['restock_items' => 'Tidak ada item pembelian yang disediakan.']);
        }
    }
}