<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada supplier dan produk terlebih dahulu
        $supplier = Supplier::firstOrCreate(
            ['email' => 'supplier@example.com'],
            [
                'name' => 'Supplier Utama',
                'supplier_type' => 'wholesale',
                'phone' => '081234567890',
                'address' => 'Jl. Supplier No. 123',
                'city' => 'Surabaya',
                'country' => 'Indonesia'
            ]
        );

        // Ambil beberapa produk
        $products = Product::take(3)->get();
        
        if ($products->isEmpty()) {
            $this->command->info('Tidak ada produk yang tersedia. Silakan jalankan ProductSeeder terlebih dahulu.');
            return;
        }

        // Buat data pembelian
        $purchaseOrder = PurchaseOrder::create([
            'purchase_number' => 'PO-' . date('Ymd') . '-' . strtoupper(uniqid()),
            'supplier_id' => $supplier->id,
            'status' => 'received',
            'payment_status' => 'dibayar',
            'payment_method' => 'transfer',
            'total_amount' => 0, // Akan diupdate setelah menambahkan item
            'notes' => 'Pembelian rutin bulanan',
        ]);

        $totalAmount = 0;
        
        // Tambahkan item pembelian
        foreach ($products as $product) {
            $quantity = rand(5, 20);
            $price = $product->purchase_price ?? rand(10000, 100000);
            $subtotal = $quantity * $price;
            
            $purchaseOrder->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
            
            $totalAmount += $subtotal;
        }

        // Update total amount
        $purchaseOrder->update([
            'total_amount' => $totalAmount,
            'received_amount' => $totalAmount,
        ]);

        $this->command->info('Data pembelian berhasil ditambahkan!');
    }
}
