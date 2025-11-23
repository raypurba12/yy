<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ColdStorageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RestockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:admin,kasir,pemilik,user,customer'])->name('dashboard');
Route::get('/dashboard/data', [App\Http\Controllers\DashboardController::class, 'getData'])->middleware(['auth', 'verified', 'role:admin,kasir,pemilik,user,customer'])->name('dashboard.data');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Product routes
    Route::resource('products', ProductController::class);
    
    // Inventory routes
    Route::resource('inventory', InventoryController::class);
    Route::get('/inventory/{inventory}/restock', [InventoryController::class, 'restockForm'])->name('inventory.restock.form');
    Route::post('/inventory/{inventory}/restock', [InventoryController::class, 'restock'])->name('inventory.restock');
    
    // Order routes
    Route::resource('orders', OrderController::class);
    Route::post('/orders/calculate-change', [OrderController::class, 'calculateChange'])->name('orders.calculate-change');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'printReceipt'])->name('orders.receipt');
    
    // Customer routes
    Route::resource('customers', CustomerController::class);
    
    // Supplier routes
    Route::resource('suppliers', SupplierController::class);
    Route::get('/suppliers/{supplier}/orders', [SupplierController::class, 'orders'])->name('suppliers.orders');
    
    // Restock routes
    Route::resource('restocks', RestockController::class);
    Route::post('/restocks/calculate-change', [RestockController::class, 'calculateChange'])->name('restocks.calculate-change');
    
    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/reports/suppliers', [ReportController::class, 'suppliers'])->name('reports.suppliers');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/sales/export-excel', [ReportController::class, 'exportSalesExcel'])->name('reports.sales.export-excel');
    Route::get('/reports/inventory/export-excel', [ReportController::class, 'exportInventoryExcel'])->name('reports.inventory.export-excel');
    Route::get('/reports/suppliers/export-excel', [ReportController::class, 'exportSuppliersExcel'])->name('reports.suppliers.export-excel');
    
    // Cold Storage routes
    Route::resource('cold-storage', ColdStorageController::class);
    
    // Purchase Order routes
    Route::resource('purchase-orders', \App\Http\Controllers\PurchaseOrderController::class);
    Route::post('/purchase-orders/calculate-change', [\App\Http\Controllers\PurchaseOrderController::class, 'calculateChange'])->name('purchase-orders.calculate-change');
    Route::get('/purchase-orders/{purchaseOrder}/receipt', [\App\Http\Controllers\PurchaseOrderController::class, 'printReceipt'])->name('purchase-orders.receipt');
    Route::get('/purchase-orders/reports', [\App\Http\Controllers\PurchaseOrderController::class, 'reports'])->name('purchase-orders.reports');
    Route::get('/reports/purchase-orders', [\App\Http\Controllers\ReportController::class, 'purchaseOrders'])->name('reports.purchase-orders');
    Route::get('/reports/purchase-orders/export', [\App\Http\Controllers\ReportController::class, 'exportPurchaseOrders'])->name('reports.purchase-orders.export');
    // Restock Purchase Report routes
    Route::get('/reports/restock-purchases', [\App\Http\Controllers\ReportController::class, 'restockPurchases'])->name('reports.restock-purchases');
    Route::get('/reports/restock-purchases/export', [\App\Http\Controllers\ReportController::class, 'exportRestockPurchases'])->name('reports.restock-purchases.export');
    
    // User management routes - only for admin
    Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('role:admin');
});

require __DIR__.'/auth.php';
