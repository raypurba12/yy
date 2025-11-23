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
            // Drop existing foreign key constraint first
            $table->dropForeign(['customer_id']);

            // Make customer_id nullable
            $table->unsignedBigInteger('customer_id')->nullable()->change();

            // Recreate foreign key, set null on delete
            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert: make customer_id NOT NULL again and restore cascade delete
            $table->dropForeign(['customer_id']);

            $table->unsignedBigInteger('customer_id')->nullable(false)->change();

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');
        });
    }
};
