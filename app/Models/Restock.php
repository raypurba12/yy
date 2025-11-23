<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restock extends Model
{
    protected $fillable = [
        'restock_number',
        'supplier_id',
        'user_id',
        'purchase_date',
        'total_amount',
        'payment_status',
        'payment_method',
        'received_amount',
        'change_amount',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_amount' => 'decimal:2',
        'received_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function restockItems(): HasMany
    {
        return $this->hasMany(RestockItem::class);
    }

    /**
     * Generate unique restock number
     */
    public static function generateRestockNumber(): string
    {
        $date = date('Ymd');
        $random = strtoupper(bin2hex(random_bytes(2)));
        
        // Get the count of restocks for today
        $todayRestocks = self::whereDate('created_at', date('Y-m-d'))->count();
        $sequence = str_pad($todayRestocks + 1, 4, '0', STR_PAD_LEFT);
        
        return "RES{$date}{$sequence}{$random}";
    }
}
