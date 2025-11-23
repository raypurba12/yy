<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_number',
        'supplier_id',
        'status',
        'payment_status',
        'payment_method',
        'total_amount',
        'received_amount',
        'change_amount',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'received_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function scopeWithDetails($query)
    {
        return $query->with(['supplier', 'purchaseOrderItems.product']);
    }
}