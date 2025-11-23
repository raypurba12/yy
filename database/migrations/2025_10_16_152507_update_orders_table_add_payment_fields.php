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
        Schema::table('orders', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('orders', 'received_amount')) {
                $table->decimal('received_amount', 15, 2)->nullable()->after('payment_method');
            }
            
            if (!Schema::hasColumn('orders', 'change_amount')) {
                $table->decimal('change_amount', 15, 2)->nullable()->after('received_amount');
            }
            
            // Update payment_status column default value if needed
            $table->string('payment_status')->default('belum_dibayar')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'received_amount', 'change_amount']);
        });
    }
};
