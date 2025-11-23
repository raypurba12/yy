<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'PT. Segar Indah Ikan',
            'email' => 'info@segarindahikan.com',
            'phone' => '021-555-1234',
            'address' => 'Jl. Raya Bekasi No. 123',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'company' => 'PT. Segar Indah Ikan',
            'tax_id' => '01.234.567.8-901.234',
            'notes' => 'Supplier ikan segar dan beku terpercaya sejak 2010',
        ]);

        Supplier::create([
            'name' => 'CV. Laut Biru Perkasa',
            'email' => 'contact@lautbiru.com',
            'phone' => '021-555-5678',
            'address' => 'Jl. Pelabuhan Ratu No. 45',
            'city' => 'Surabaya',
            'country' => 'Indonesia',
            'company' => 'CV. Laut Biru Perkasa',
            'tax_id' => '02.345.678.9-012.345',
            'notes' => 'Spesialis ikan hias dan konsumsi laut dalam',
        ]);

        Supplier::create([
            'name' => 'UD. Ikan Manis',
            'email' => 'ikanmanis@gmail.com',
            'phone' => '021-555-9012',
            'address' => 'Komplek PPI Marunda, Blok A No. 7',
            'city' => 'Ciledug',
            'country' => 'Indonesia',
            'company' => 'UD. Ikan Manis',
            'tax_id' => '03.456.789.0-123.456',
            'notes' => 'Supplier ikan segar lokal dan impor',
        ]);

        Supplier::create([
            'name' => 'PT. Nelayan Makmur',
            'email' => 'admin@nelayanmakmur.com',
            'phone' => '021-555-3456',
            'address' => 'Jl. H. Mochtar Raya No. 200',
            'city' => 'Tangerang',
            'country' => 'Indonesia',
            'company' => 'PT. Nelayan Makmur',
            'tax_id' => '04.567.890.1-234.567',
            'notes' => 'Supplier ikan lokal hasil tangkapan nelayan',
        ]);

        Supplier::create([
            'name' => 'CV. Ikan Laut Segar',
            'email' => 'order@ikanlautsegar.com',
            'phone' => '021-555-7890',
            'address' => 'Pasar Ikan Muara Baru, Los B-15',
            'city' => 'Jakarta Utara',
            'country' => 'Indonesia',
            'company' => 'CV. Ikan Laut Segar',
            'tax_id' => '05.678.901.2-345.678',
            'notes' => 'Supplier ikan laut segar dan beku dari nelayan lokal',
        ]);
    }
}
