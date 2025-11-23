<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing 'staff' roles to 'kasir'
        \DB::table('users')
            ->where('role', 'staff')
            ->update(['role' => 'kasir']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'kasir' roles back to 'staff'
        \DB::table('users')
            ->where('role', 'kasir')
            ->update(['role' => 'staff']);
    }
};
