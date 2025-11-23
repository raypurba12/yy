<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for dashboard
        $totalProducts = Product::count();
        $totalOrdersToday = Order::whereDate('created_at', now())->count();
        $totalRevenue = Order::whereDate('created_at', now())->sum('total_amount');
        $totalCustomers = Customer::count();
        $totalInventory = Inventory::sum('quantity');
        
        // Get low stock and out of stock product counts
        $lowStockProducts = Inventory::where('quantity', '>', 0)->whereColumn('quantity', '<=', 'min_stock')->count(); // Below or equal to minimum stock
        $outOfStockProducts = Inventory::where('quantity', 0)->count();
        
        // Get recent orders - limit based on user role
        if ($user->hasRole(['admin', 'kasir'])) {
            $recentOrders = Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            // For user/customer roles, we need to determine if they have specific order access
            // For now, showing all orders as there might not be a direct relationship between User and Order
            $recentOrders = Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        // Get top selling products
        $topProducts = Product::withSum('orderItems as orders_sum_quantity', 'quantity')
            ->orderBy('orders_sum_quantity', 'desc')
            ->limit(5)
            ->get();
        
        // Get sales data for chart
        $salesData = $this->getSalesData();
        
        // Get product distribution
        $productDistribution = $this->getProductDistribution();
        
        return view('dashboard', compact(
            'totalProducts',
            'totalOrdersToday', 
            'totalRevenue',
            'totalCustomers',
            'totalInventory',
            'lowStockProducts',
            'outOfStockProducts',
            'recentOrders',
            'topProducts',
            'salesData',
            'productDistribution',
            'user'
        ));
    }
    
    public function getData()
    {
        $user = Auth::user();
        
        $totalProducts = Product::count();
        $totalOrdersToday = Order::whereDate('created_at', now())->count();
        $totalRevenue = Order::whereDate('created_at', now())->sum('total_amount');
        $totalCustomers = Customer::count();
        $totalInventory = Inventory::sum('quantity');
        
        // Get low stock and out of stock product counts
        $lowStockProducts = Inventory::where('quantity', '>', 0)->whereColumn('quantity', '<=', 'min_stock')->count(); // Below or equal to minimum stock
        $outOfStockProducts = Inventory::where('quantity', 0)->count();
        
        // Get recent orders - limit based on user role
        if ($user->hasRole(['admin', 'kasir'])) {
            $recentOrders = Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            // For user/customer roles, showing all orders for now
            $recentOrders = Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        // Get top selling products
        $topProducts = Product::withSum('orderItems as orders_sum_quantity', 'quantity')
            ->orderBy('orders_sum_quantity', 'desc')
            ->limit(5)
            ->get();
        
        return response()->json([
            'totalProducts' => $totalProducts,
            'totalOrdersToday' => $totalOrdersToday,
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'totalInventory' => $totalInventory,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'recentOrders' => $recentOrders->map(function($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->customer,
                    'total_amount' => $order->total_amount,
                    'status_label' => $order->status_label,
                    'status_color' => $order->status_color,
                    'status_text_color' => $order->status_text_color,
                    'status_bg_dark_color' => $order->status_bg_dark_color,
                    'status_text_dark_color' => $order->status_text_dark_color
                ];
            }),
            'topProducts' => $topProducts->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'weight' => $product->weight,
                    'unit' => $product->unit,
                    'price' => $product->price,
                    'orders_sum_quantity' => $product->orders_sum_quantity,
                    'color_class' => $product->color_class,
                    'text_color_class' => $product->text_color_class,
                ];
            }),
        ]);
    }
    
    private function getSalesData()
    {
        // Get sales data for the last 7 days
        $dates = [];
        $sales = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->format('l'); // Day name
            $sales[] = Order::whereDate('created_at', $date)->sum('total_amount') / 1000000; // Convert to millions
        }
        
        return [
            'labels' => $dates,
            'data' => $sales
        ];
    }
    
    private function getProductDistribution()
    {
        // Get product distribution by category
        $products = Product::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();
            
        $labels = [];
        $data = [];
        
        foreach ($products as $product) {
            $labels[] = $product->category;
            $data[] = $product->count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}