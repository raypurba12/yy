<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah tipe kolom status dan payment_status ke string
        DB::statement("ALTER TABLE orders MODIFY status VARCHAR(20) NOT NULL");
        DB::statement("ALTER TABLE orders MODIFY payment_status VARCHAR(20) NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan ke enum lama (kalau mau rollback)
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending'");
        DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending'");
    }
};
