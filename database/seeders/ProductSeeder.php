<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Tuna Sirip Kuning',
                'description' => 'Ikan tuna berkualitas tinggi dengan sirip kuning',
                'price' => 185000,
                'weight' => 1.2,
                'unit' => 'kg',
                'category' => 'Tuna',
                'image' => 'tuna.jpg'
            ],
            [
                'name' => 'Salmon Premium',
                'description' => 'Ikan salmon segar dari laut dalam',
                'price' => 220000,
                'weight' => 1.5,
                'unit' => 'kg',
                'category' => 'Salmon',
                'image' => 'salmon.jpg'
            ],
            [
                'name' => 'Cakalang Fillet',
                'description' => 'Fillet ikan cakalang segar, siap masak',
                'price' => 120000,
                'weight' => 1.0,
                'unit' => 'kg',
                'category' => 'Cakalang',
                'image' => 'cakalang.jpg'
            ],
            [
                'name' => 'Gurita Segar',
                'description' => 'Gurita segar ukuran sedang, daging lembut',
                'price' => 320000,
                'weight' => 0.8,
                'unit' => 'kg',
                'category' => 'Gurita',
                'image' => 'gurita.jpg'
            ],
            [
                'name' => 'Kerapu Gurih',
                'description' => 'Ikan kerapu segar, gurih dan lembut',
                'price' => 450000,
                'weight' => 2.0,
                'unit' => 'kg',
                'category' => 'Kerapu',
                'image' => 'kerapu.jpg'
            ],
            [
                'name' => 'Kakap Merah',
                'description' => 'Ikan kakap merah segar untuk masakan premium',
                'price' => 195000,
                'weight' => 1.3,
                'unit' => 'kg',
                'category' => 'Kakap',
                'image' => 'kakap.jpg'
            ],
            [
                'name' => 'Tongkol Bulat',
                'description' => 'Ikan tongkol bulat segar untuk masakan rumahan',
                'price' => 95000,
                'weight' => 1.1,
                'unit' => 'kg',
                'category' => 'Tongkol',
                'image' => 'tongkol.jpg'
            ],
            [
                'name' => 'Ikan Tenggiri',
                'description' => 'Ikan tenggiri segar, lezat dimasak berbagai cara',
                'price' => 140000,
                'weight' => 1.0,
                'unit' => 'kg',
                'category' => 'Tenggiri',
                'image' => 'tenggiri.jpg'
            ],
        ];

        foreach ($products as $product) {
            // Check if product already exists by name to prevent duplicate key violations
            if (!Product::where('name', $product['name'])->exists()) {
                Product::create($product);
            }
        }
    }
}