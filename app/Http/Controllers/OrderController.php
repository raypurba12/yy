<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::with('inventory')->get(); // Include inventory data
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['belum_dibayar', 'dibayar', 'gagal'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris'])],
            'received_amount' => 'nullable|numeric|min:0',
            'change_amount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ]);

        // Generate unique order number
        $orderNumber = $this->generateOrderNumber();

        // Create order items and calculate total amount first
        $totalAmount = 0;
        $changeAmount = null;
        $receivedAmount = $request->received_amount;
        $rawDiscount = max(0, (float) $request->input('discount', 0));
        $discountType = $request->input('discount_type', 'nominal');
        
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

            // Compute effective discount based on type (nominal or percent)
            $effectiveDiscount = 0;
            if ($discountType === 'percent') {
                $effectiveDiscount = $totalAmount * ($rawDiscount / 100);
            } else {
                $effectiveDiscount = $rawDiscount;
            }

            $effectiveDiscount = max(0, min($effectiveDiscount, $totalAmount));
            $totalAmount = max(0, $totalAmount - $effectiveDiscount);
            
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
            
            // Create the order first (do not persist raw discount fields, only final total_amount)
            $orderData = $request->except('order_items', 'discount', 'discount_type', 'discount_note');
            $orderData['order_number'] = $orderNumber;
            $orderData['total_amount'] = $totalAmount;
            $orderData['received_amount'] = $receivedAmount;
            $orderData['change_amount'] = $changeAmount;
            
            $order = Order::create($orderData);
            
            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully.',
                'order_id' => $order->id,
                'order_number' => $orderNumber
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
     * Generate unique order number.
     */
    private function generateOrderNumber()
    {
        $date = date('Ymd');
        $random = strtoupper(bin2hex(random_bytes(2)));
        
        // Get the count of orders for today
        $todayOrders = Order::whereDate('created_at', date('Y-m-d'))->count();
        $sequence = str_pad($todayOrders + 1, 4, '0', STR_PAD_LEFT);
        
        return "ORD{$date}{$sequence}{$random}";
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('customer', 'orderItems.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = Customer::all();
        $products = Product::all();
        $order->load('orderItems.product');
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'order_number' => 'required|string|unique:orders,order_number,' . $order->id,
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['belum_dibayar', 'dibayar', 'gagal'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris'])],
            'received_amount' => 'nullable|numeric|min:0',
            'change_amount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
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
        $rawDiscount = max(0, (float) $request->input('discount', 0));
        $discountType = $request->input('discount_type', 'nominal');
        
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

            // Compute effective discount based on type
            $effectiveDiscount = 0;
            if ($discountType === 'percent') {
                $effectiveDiscount = $totalAmount * ($rawDiscount / 100);
            } else {
                $effectiveDiscount = $rawDiscount;
            }

            $effectiveDiscount = max(0, min($effectiveDiscount, $totalAmount));
            $totalAmount = max(0, $totalAmount - $effectiveDiscount);
            
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
            
            // Update the order (exclude raw discount fields)
            $orderData = $request->except('order_items', 'discount', 'discount_type', 'discount_note');
            $orderData['total_amount'] = $totalAmount;
            $orderData['received_amount'] = $receivedAmount;
            $orderData['change_amount'] = $changeAmount;
            
            $order->update($orderData);

            // Update order items
            // Delete existing order items
            $order->orderItems()->delete();
            
            // Create new order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            // Check if request wants JSON response (from AJAX)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order updated successfully.',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            } else {
                return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
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
     * Display the receipt for the specified order.
     */
    public function printReceipt(Order $order)
    {
        $order->load('customer', 'orderItems.product');
        
        return view('orders.receipt', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}