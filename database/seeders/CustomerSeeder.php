<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Ahmad Santoso',
                'email' => 'ahmad@example.com',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'city' => 'Jakarta',
                'country' => 'Indonesia'
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 45, Surabaya',
                'city' => 'Surabaya',
                'country' => 'Indonesia'
            ],
            [
                'name' => 'Budi Prasetyo',
                'email' => 'budi@example.com',
                'phone' => '081234567892',
                'address' => 'Jl. Gatot Subroto No. 67, Bandung',
                'city' => 'Bandung',
                'country' => 'Indonesia'
            ],
            [
                'name' => 'Dewi Kusuma',
                'email' => 'dewi@example.com',
                'phone' => '081234567893',
                'address' => 'Jl. Ahmad Yani No. 89, Medan',
                'city' => 'Medan',
                'country' => 'Indonesia'
            ],
            [
                'name' => 'Rizki Firmansyah',
                'email' => 'rizki@example.com',
                'phone' => '081234567894',
                'address' => 'Jl. Diponegoro No. 101, Makassar',
                'city' => 'Makassar',
                'country' => 'Indonesia'
            ],
        ];

        foreach ($customers as $customer) {
            // Check if customer already exists by email to prevent duplicate key violations
            if (!Customer::where('email', $customer['email'])->exists()) {
                Customer::create($customer);
            }
        }
    }
}