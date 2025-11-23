<?php

namespace Database\Seeders;

use App\Models\ColdStorage;
use Illuminate\Database\Seeder;

class ColdStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coldStorages = [
            [
                'name' => 'Gudang Utama',
                'location' => 'Area Penyimpanan A, Lantai 1',
                'current_temperature' => -18.00,
                'target_temperature' => -18.00,
                'status' => 'active',
                'description' => 'Gudang utama untuk penyimpanan ikan beku dengan kapasitas besar'
            ],
            [
                'name' => 'Gudang Cadangan',
                'location' => 'Area Penyimpanan B, Lantai 2',
                'current_temperature' => -17.50,
                'target_temperature' => -18.00,
                'status' => 'active',
                'description' => 'Gudang cadangan untuk kapasitas tambahan'
            ],
            [
                'name' => 'Unit Pendingin Darurat',
                'location' => 'Area Khusus, Lantai Dasar',
                'current_temperature' => 4.00,
                'target_temperature' => -18.00,
                'status' => 'maintenance',
                'description' => 'Unit pendingin dalam perbaikan'
            ]
        ];

        foreach ($coldStorages as $coldStorage) {
            ColdStorage::create($coldStorage);
        }
    }
}