<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColdStorage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location', 
        'current_temperature',
        'target_temperature',
        'status',
        'description',
    ];

    protected $casts = [
        'current_temperature' => 'decimal:2',
        'target_temperature' => 'decimal:2',
    ];
}
