<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierOrder;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Supplier::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }
        
        $suppliers = $query->orderBy('name')->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'table' => view('suppliers.partials.suppliers-table', compact('suppliers'))->render(),
                'pagination' => (string)$suppliers->links()
            ]);
        }
        
        return view('suppliers.index', compact('suppliers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplierTypes = ['local' => 'Lokal', 'import' => 'Impor', 'wholesale' => 'Grosir', 'retail' => 'Eceran', 'specialized' => 'Spesialis'];
        return view('suppliers.create', compact('supplierTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_type' => 'required|in:local,import,wholesale,retail,specialized',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'company' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load('supplierOrders.product');
        $recentOrders = $supplier->supplierOrders()->with('product')->latest()->limit(5)->get();

        // Get restock logs for this supplier using the hasManyThrough relationship
        $restockLogs = $supplier->inventoryRestockLogs()
            ->with(['inventory.product']) // Load the related inventory and its product
            ->orderBy('date', 'desc') // Order by date, newest first
            ->paginate(10); // Paginate for better UX

        // Get sales orders related to products supplied by this supplier
        $salesOrders = $supplier->salesOrders()->paginate(10);

        // Get new restock transactions related to this supplier
        $restocks = $supplier->restocks()
            ->with(['user', 'restockItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get purchase orders for this supplier
        $purchaseOrders = $supplier->purchaseOrders()
            ->with(['purchaseOrderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'purchase_orders_page');

        return view('suppliers.show', compact(
            'supplier', 
            'recentOrders', 
            'restockLogs', 
            'salesOrders', 
            'restocks',
            'purchaseOrders'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $supplierTypes = ['local' => 'Lokal', 'import' => 'Impor', 'wholesale' => 'Grosir', 'retail' => 'Eceran', 'specialized' => 'Spesialis'];
        return view('suppliers.edit', compact('supplier', 'supplierTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_type' => 'required|in:local,import,wholesale,retail,specialized',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'company' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Check if supplier has any products
        if ($supplier->products()->count() > 0) {
            return redirect()->route('suppliers.index')->with('error', 'Cannot delete supplier that supplies products.');
        }

        // Check if supplier has any orders
        if ($supplier->supplierOrders()->count() > 0) {
            return redirect()->route('suppliers.index')->with('error', 'Cannot delete supplier that has placed orders.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    /**
     * Display supplier orders for a specific supplier.
     */
    public function orders(Supplier $supplier)
    {
        $orders = $supplier->supplierOrders()->with('product')->paginate(10);
        return view('suppliers.orders', compact('supplier', 'orders'));
    }
}
