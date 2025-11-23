<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Restock;
use App\Models\RestockItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display a listing of different report types.
     */
    public function index()
    {
        // Get basic statistics for the dashboard view
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalPurchaseOrders = PurchaseOrder::count();
        $totalCustomers = Customer::count();
        $totalInventory = Inventory::sum('quantity');
        $totalRevenue = Order::sum('total_amount');
        
        return view('reports.index', compact(
            'totalProducts', 
            'totalOrders', 
            'totalCustomers', 
            'totalInventory', 
            'totalRevenue',
            'totalPurchaseOrders'
        ));
    }
    
    /**
     * Show sales reports
     */
    public function sales(Request $request)
    {
        $salesData = [
            'today' => Order::whereDate('created_at', today())->sum('total_amount'),
            'thisWeek' => Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
            'thisMonth' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
            'thisYear' => Order::whereYear('created_at', now()->year)->sum('total_amount'),
        ];
        
        $ordersByDate = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_sales')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $ordersQuery = Order::with('customer');

        if ($request->filled('from')) {
            $ordersQuery->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $ordersQuery->whereDate('created_at', '<=', $request->input('to'));
        }

        $orders = $ordersQuery
            ->orderByDesc('created_at')
            ->get();

        return view('reports.sales', compact('salesData', 'ordersByDate', 'orders'));
    }
    
    /**
     * Show inventory reports
     */
    public function inventory()
    {
        $lowStockProducts = Product::whereHas('inventory', function($query) {
            $query->where('quantity', '<', 10);
        })->with('inventory')->get();
        
        $totalInventory = Inventory::sum('quantity');
        
        $totalInventoryValue = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
            ->selectRaw('SUM(products.price * inventories.quantity) as total_value')
            ->first()->total_value ?? 0;
        
        $inventoryByCategory = Product::selectRaw('category, SUM(inventories.quantity) as total_quantity')
            ->join('inventories', 'products.id', '=', 'inventories.product_id')
            ->groupBy('category')
            ->get();
        
        $inventories = Inventory::with('product')->orderByDesc('updated_at')->get();

        return view('reports.inventory', compact('lowStockProducts', 'totalInventory', 'totalInventoryValue', 'inventoryByCategory', 'inventories'));
    }
    
    /**
     * Show customer reports
     */
    public function customers()
    {
        $customerStats = [
            'total' => Customer::count(),
            'newThisMonth' => Customer::whereMonth('created_at', now()->month)->count(),
        ];
        
        $topCustomers = Order::selectRaw('customer_id, COUNT(*) as order_count, SUM(total_amount) as total_spent')
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->with('customer')
            ->get();
        
        return view('reports.customers', compact('customerStats', 'topCustomers'));
    }

    /**
     * Show supplier reports
     */
    public function suppliers(Request $request)
    {
        // Supplier statistics: count suppliers and those with restock activity
        $supplierStats = [
            'total' => Supplier::count(),
            'withOrders' => Supplier::whereHas('restocks')->count(),
        ];

        // Top suppliers by number of purchase orders
        $topSuppliers = Supplier::withCount('purchaseOrders')
            ->orderByDesc('purchase_orders_count')
            ->take(5)
            ->get();

        // Build base query for purchase order items joined with their purchase order & supplier
        $purchaseOrderItemsQuery = PurchaseOrderItem::with(['purchaseOrder.supplier', 'product']);

        // Optional date filters based on purchase_orders.created_at
        if ($request->filled('from')) {
            $from = $request->input('from');

            $purchaseOrderItemsQuery->whereHas('purchaseOrder', function ($q) use ($from) {
                $q->whereDate('created_at', '>=', $from);
            });
        }

        if ($request->filled('to')) {
            $to = $request->input('to');

            $purchaseOrderItemsQuery->whereHas('purchaseOrder', function ($q) use ($to) {
                $q->whereDate('created_at', '<=', $to);
            });
        }

        // Map purchase order items into the flat structure expected by the view
        $supplierPurchases = $purchaseOrderItemsQuery
            ->get()
            ->map(function (PurchaseOrderItem $item) {
                $purchaseOrder = $item->purchaseOrder;

                return (object) [
                    'date' => optional($purchaseOrder?->created_at)->format('Y-m-d'),
                    'order_number' => $purchaseOrder?->purchase_number,
                    'supplier' => optional($purchaseOrder?->supplier),
                    'product' => optional($item->product),
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->quantity * $item->price,
                    'source' => 'supplier_order',
                ];
            })
            ->filter(function ($row) {
                return $row->date !== null && $row->supplier !== null;
            })
            ->sortByDesc('date')
            ->values();

        return view('reports.suppliers', [
            'supplierStats' => $supplierStats,
            'topSuppliers' => $topSuppliers,
            'supplierPurchases' => $supplierPurchases,
        ]);
    }
    
    /**
     * Export report as PDF
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'sales');
        $filename = 'report_' . $type . '_' . date('Y-m-d') . '.pdf';
        
        switch($type) {
            case 'sales':
                return $this->exportSalesReport()->download($filename);
            case 'inventory':
                return $this->exportInventoryReport()->download($filename);
            case 'customers':
                return $this->exportCustomerReport()->download($filename);
            case 'suppliers':
                return $this->exportSuppliersReport()->download($filename);
            default:
                return $this->exportSalesReport()->download($filename);
        }
    }
    
    private function exportSalesReport()
    {
        $salesData = [
            'today' => Order::whereDate('created_at', today())->sum('total_amount'),
            'thisWeek' => Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
            'thisMonth' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
            'thisYear' => Order::whereYear('created_at', now()->year)->sum('total_amount'),
        ];
        
        $ordersByDate = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_sales')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $orders = Order::with('customer')
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('reports.exports.sales', compact('salesData', 'ordersByDate', 'orders'));
        return $pdf;
    }

    /**
     * Export all sales orders as an Excel-compatible CSV file
     */
    public function exportSalesExcel()
    {
        $fileName = 'sales_report_' . date('Y-m-d') . '.csv';

        $orders = Order::with('customer')
            ->orderBy('created_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($orders) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'Tanggal',
                'Nomor Pesanan',
                'Pelanggan',
                'Total',
                'Metode Pembayaran',
                'Status',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    optional($order->created_at)->format('Y-m-d H:i:s'),
                    $order->order_number,
                    optional($order->customer)->name ?? 'Pelanggan Umum',
                    $order->total_amount,
                    $order->payment_method,
                    $order->status_label,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Export supplier orders data as an Excel-compatible CSV file
     */
    public function exportSuppliersExcel()
    {
        $fileName = 'supplier_orders_' . date('Y-m-d') . '.csv';

        $orders = SupplierOrder::with(['supplier', 'product'])
            ->orderBy('order_date')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($orders) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'Tanggal Pesanan',
                'Nama Supplier',
                'Nama Produk',
                'Jumlah',
                'Harga Satuan',
                'Total Harga',
                'Status',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    optional($order->order_date)->format('Y-m-d'),
                    optional($order->supplier)->name,
                    optional($order->product)->name,
                    $order->quantity_ordered,
                    $order->unit_price,
                    $order->total_price,
                    $order->status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Export inventory stock data as an Excel-compatible CSV file
     */
    public function exportInventoryExcel()
    {
        $fileName = 'inventory_report_' . date('Y-m-d') . '.csv';

        $inventories = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
            ->select('products.name', 'products.category', 'products.price', 'inventories.quantity')
            ->orderBy('products.name')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($inventories) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'Nama Produk',
                'Kategori',
                'Harga Satuan',
                'Jumlah Stok',
                'Nilai Stok',
            ]);

            foreach ($inventories as $item) {
                $stockValue = ($item->price ?? 0) * ($item->quantity ?? 0);

                fputcsv($handle, [
                    $item->name,
                    $item->category,
                    $item->price,
                    $item->quantity,
                    $stockValue,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    private function exportInventoryReport()
    {
        $lowStockProducts = Product::whereHas('inventory', function($query) {
            $query->where('quantity', '<', 10);
        })->with('inventory')->get();
        
        $totalInventory = Inventory::sum('quantity');
        
        $totalInventoryValue = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
            ->selectRaw('SUM(products.price * inventories.quantity) as total_value')
            ->first()->total_value ?? 0;
        
        $inventoryByCategory = Product::selectRaw('category, SUM(inventories.quantity) as total_quantity')
            ->join('inventories', 'products.id', '=', 'inventories.product_id')
            ->groupBy('category')
            ->get();
        
        $inventories = Inventory::with('product')->orderByDesc('updated_at')->get();

        $pdf = Pdf::loadView('reports.exports.inventory', compact('lowStockProducts', 'totalInventory', 'totalInventoryValue', 'inventoryByCategory', 'inventories'));
        return $pdf;
    }
    
    private function exportCustomerReport()
    {
        $customerStats = [
            'total' => Customer::count(),
            'newThisMonth' => Customer::whereMonth('created_at', now()->month)->count(),
        ];
        
        $topCustomers = Order::selectRaw('customer_id, COUNT(*) as order_count, SUM(total_amount) as total_spent')
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->with('customer')
            ->get();
        
        $pdf = Pdf::loadView('reports.exports.customers', compact('customerStats', 'topCustomers'));
        return $pdf;
    }
    
    private function exportSuppliersReport()
    {
        // Build the same supplierPurchases collection used in the suppliers() method
        $purchaseOrderItemsQuery = PurchaseOrderItem::with(['purchaseOrder.supplier', 'product']);

        $supplierPurchases = $purchaseOrderItemsQuery
            ->get()
            ->map(function (PurchaseOrderItem $item) {
                $purchaseOrder = $item->purchaseOrder;

                return (object) [
                    'date' => optional($purchaseOrder?->created_at)->format('Y-m-d'),
                    'order_number' => $purchaseOrder?->purchase_number,
                    'supplier' => optional($purchaseOrder?->supplier),
                    'product' => optional($item->product),
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->quantity * $item->price,
                ];
            })
            ->filter(function ($row) {
                return $row->date !== null && $row->supplier !== null;
            })
            ->sortByDesc('date')
            ->values();

        $pdf = Pdf::loadView('reports.exports.suppliers', [
            'supplierPurchases' => $supplierPurchases,
        ]);

        return $pdf;
    }
    
    /**
     * Show purchase order reports
     */
    public function purchaseOrders()
    {
        $purchaseOrderStats = [
            'today' => PurchaseOrder::whereDate('created_at', today())->sum('total_amount'),
            'thisWeek' => PurchaseOrder::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
            'thisMonth' => PurchaseOrder::whereMonth('created_at', now()->month)->sum('total_amount'),
            'thisYear' => PurchaseOrder::whereYear('created_at', now()->year)->sum('total_amount'),
        ];
        
        $purchaseOrdersByDate = PurchaseOrder::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_amount')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('reports.purchase-orders', compact('purchaseOrderStats', 'purchaseOrdersByDate'));
    }
    
    /**
     * Export purchase order report as PDF
     */
    public function exportPurchaseOrders()
    {
        $purchaseOrderStats = [
            'today' => PurchaseOrder::whereDate('created_at', today())->sum('total_amount'),
            'thisWeek' => PurchaseOrder::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
            'thisMonth' => PurchaseOrder::whereMonth('created_at', now()->month)->sum('total_amount'),
            'thisYear' => PurchaseOrder::whereYear('created_at', now()->year)->sum('total_amount'),
        ];
        
        $purchaseOrdersByDate = PurchaseOrder::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_amount')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $pdf = Pdf::loadView('reports.exports.purchase-orders', compact('purchaseOrderStats', 'purchaseOrdersByDate'));
        return $pdf->download('purchase_order_report_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Show restock purchase reports (based on inventory_restock_logs)
     */
    public function restockPurchases()
    {
        // Fetch restock logs with related inventory and supplier
        $restockLogs = \App\Models\InventoryRestockLog::with(['inventory.product', 'supplier'])
            ->orderBy('date', 'desc')
            ->paginate(20); // Paginate for better UX on the report page

        // Calculate some summary statistics
        $totalRestockedItems = $restockLogs->sum('quantity_added');
        $totalRestocks = $restockLogs->count();

        // You can add more complex calculations here if needed, e.g., total value of restocks if price is known at restock time
        // For now, we'll just pass the logs and basic stats

        return view('reports.restock-purchases', compact('restockLogs', 'totalRestockedItems', 'totalRestocks'));
    }

    /**
     * Export restock purchase report as PDF
     */
    public function exportRestockPurchases()
    {
        // Fetch all restock logs for the PDF export
        $restockLogs = \App\Models\InventoryRestockLog::with(['inventory.product', 'supplier'])
            ->orderBy('date', 'desc')
            ->get(); // Use get() for PDF, not paginate

        $totalRestockedItems = $restockLogs->sum('quantity_added');
        $totalRestocks = $restockLogs->count();

        $pdf = Pdf::loadView('reports.exports.restock-purchases', compact('restockLogs', 'totalRestockedItems', 'totalRestocks'));
        return $pdf->download('restock_purchase_report_' . date('Y-m-d') . '.pdf');
    }
}