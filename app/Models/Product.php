<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'weight',
        'unit',
        'category',
        'image',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function inventory()
    {
        // Use the latest inventory record for this product so stock stays in sync
        return $this->hasOne(Inventory::class)->latestOfMany();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusColorAttribute()
    {
        return 'blue-100';
    }

    public function getStatusTextClassAttribute()
    {
        return 'blue-600';
    }

    public function getColorClassAttribute()
    {
        $colors = [
            'bg-blue-100', 'bg-gray-100', 'bg-amber-100', 
            'bg-purple-100', 'bg-red-100', 'bg-green-100'
        ];
        
        return $colors[($this->id - 1) % count($colors)];
    }

    public function getTextColorClassAttribute()
    {
        $colors = [
            'text-blue-600', 'text-gray-600', 'text-amber-600', 
            'text-purple-600', 'text-red-600', 'text-green-600'
        ];
        
        return $colors[($this->id - 1) % count($colors)];
    }
}