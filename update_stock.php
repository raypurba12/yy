<?php
// update_stock.php

require_once 'vendor/autoload.php';

use App\Models\Product;
use App\Models\Inventory;

// Inisialisasi Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Ambil semua produk dan perbarui kolom stock berdasarkan inventory
$products = Product::all();

foreach ($products as $product) {
    $inventory = $product->inventory;
    if ($inventory) {
        $product->update(['stock' => $inventory->quantity]);
        echo "Updated product {$product->id} with stock {$inventory->quantity}\n";
    } else {
        $product->update(['stock' => 0]);
        echo "Updated product {$product->id} with stock 0 (no inventory)\n";
    }
}

echo "Stock update completed!\n";