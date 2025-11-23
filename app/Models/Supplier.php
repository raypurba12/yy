<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supplier_type',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'company',
        'tax_id',
        'notes',
    ];

    protected $casts = [
        'supplier_type' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function supplierOrders()
    {
        return $this->hasMany(SupplierOrder::class);
    }

    public function inventoryRestockLogs()
    {
        return $this->hasManyThrough(\App\Models\InventoryRestockLog::class, \App\Models\Inventory::class, 'supplier_id', 'inventory_id', 'id', 'id');
    }

    public function salesOrders()
    {
        // Subquery untuk mendapatkan product_id yang disuplai oleh supplier ini (melalui inventory)
        $productIdsFromSupplier = $this->inventories()->select('product_id');

        // Query untuk mendapatkan Order yang produknya berasal dari supplier ini
        return Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
              ->join('products', 'order_items.product_id', '=', 'products.id')
              ->whereIn('products.id', $productIdsFromSupplier)
              ->select('orders.*') // Pastikan hanya mengambil kolom dari orders
              ->with(['customer']) // Eager load customer untuk tampilan
              ->orderBy('orders.created_at', 'desc')
              ->distinct(); // Hindari duplikasi jika satu order memiliki banyak produk dari supplier
    }

    public function restocks()
    {
        return $this->hasMany(\App\Models\Restock::class);
    }

    /**
     * Get all of the purchase orders for the supplier.
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}