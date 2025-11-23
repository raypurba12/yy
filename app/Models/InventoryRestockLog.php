<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryRestockLog extends Model
{
    protected $fillable = [
        'inventory_id',
        'supplier_id',
        'quantity_added',
        'date',
        'notes',
    ];

    protected $casts = [
        'date' => 'datetime', // Atau 'date' jika hanya tanggal
        'quantity_added' => 'integer',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
