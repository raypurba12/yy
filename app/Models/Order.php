<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'received_amount',
        'change_amount',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'received_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'order_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Belum Bayar',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBgColorAttribute()
    {
        $colors = [
            'pending' => 'yellow-100',
            'processing' => 'blue-100',
            'completed' => 'green-100',
            'cancelled' => 'gray-100',
        ];
        
        return $colors[$this->status] ?? 'blue-100';
    }

    public function getStatusTextColorAttribute()
    {
        $colors = [
            'pending' => 'yellow-800',
            'processing' => 'blue-800',
            'completed' => 'green-800',
            'cancelled' => 'gray-800',
        ];
        
        return $colors[$this->status] ?? 'blue-800';
    }

    public function getStatusBgDarkColorAttribute()
    {
        $colors = [
            'pending' => 'yellow-900/30',
            'processing' => 'blue-900/30',
            'completed' => 'green-900/30',
            'cancelled' => 'gray-900/30',
        ];
        
        return $colors[$this->status] ?? 'blue-900/30';
    }

    public function getStatusTextDarkColorAttribute()
    {
        $colors = [
            'pending' => 'yellow-300',
            'processing' => 'blue-300',
            'completed' => 'green-300',
            'cancelled' => 'gray-300',
        ];
        
        return $colors[$this->status] ?? 'blue-300';
    }

    /**
     * Get all available order statuses
     * 
     * @return array
     */
    public static function getStatuses()
    {
        return [
            'pending' => 'Belum Bayar',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }
}