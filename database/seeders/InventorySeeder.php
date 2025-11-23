<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products and create inventory records for them
        $products = Product::all();
        
        if ($products->count() > 0) {
            foreach ($products as $product) {
                // Only create inventory for products that don't already have inventory
                if (!$product->inventory) {
                    Inventory::create([
                        'product_id' => $product->id,
                        'quantity' => rand(10, 100), // Random quantity between 10-100 as example
                        'min_stock' => 5, // Default minimum stock
                        'max_stock' => 200, // Default maximum stock
                        'location' => 'Gudang Utama', // Default location
                    ]);
                }
            }
        }
        
        // If no products exist, create sample inventory for demonstration
        if ($products->count() == 0) {
            // First create some sample products
            $sampleProducts = [
                [
                    'name' => 'Ikan Tuna Segar',
                    'description' => 'Ikan tuna segar pilihan, ideal untuk konsumsi sehat',
                    'price' => 85000,
                    'weight' => 1.0,
                    'unit' => 'kg',
                    'category' => 'Ikan Tuna',
                ],
                [
                    'name' => 'Ikan Salmon Premium',
                    'description' => 'Ikan salmon premium, kaya omega-3',
                    'price' => 120000,
                    'weight' => 1.0,
                    'unit' => 'kg',
                    'category' => 'Ikan Salmon',
                ],
                [
                    'name' => 'Ikan Gurame Beku',
                    'description' => 'Ikan gurame berkualitas tinggi',
                    'price' => 75000,
                    'weight' => 1.0,
                    'unit' => 'kg',
                    'category' => 'Ikan Gurame',
                ],
                [
                    'name' => 'Ikan Kakap Merah',
                    'description' => 'Ikan kakap merah segar untuk masakan premium',
                    'price' => 95000,
                    'weight' => 1.0,
                    'unit' => 'kg',
                    'category' => 'Ikan Kakap',
                ],
                [
                    'name' => 'Ikan Bandeng Presto',
                    'description' => 'Ikan bandeng presto siap masak',
                    'price' => 65000,
                    'weight' => 1.0,
                    'unit' => 'kg',
                    'category' => 'Ikan Bandeng',
                ]
            ];
            
            $createdProducts = [];
            foreach ($sampleProducts as $productData) {
                $product = Product::create($productData);
                $createdProducts[] = $product;
            }
            
            // Now create inventory for these products
            foreach ($createdProducts as $product) {
                Inventory::create([
                    'product_id' => $product->id,
                    'quantity' => rand(20, 150), // Random quantity between 20-150 as example
                    'min_stock' => 10, // Default minimum stock
                    'max_stock' => 300, // Default maximum stock
                    'location' => 'Gudang Utama', // Default location
                ]);
            }
        }
    }
}
