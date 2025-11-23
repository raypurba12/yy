<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            // Pastikan ProductSeeder dan SupplierSeeder dijalankan terlebih dahulu
            // karena PurchaseOrderSeeder membutuhkannya
            ProductSeeder::class,
            SupplierSeeder::class,
            PurchaseOrderSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
            InventorySeeder::class,
            ColdStorageSeeder::class,
        ]);
    }
}
