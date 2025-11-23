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
        Schema::create('cold_storages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'Gudang Utama', 'Gudang Cadangan'
            $table->string('location');
            $table->decimal('current_temperature', 5, 2); // Current temperature in Celsius
            $table->decimal('target_temperature', 5, 2); // Target temperature
            $table->string('status')->default('active'); // active, maintenance, offline
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cold_storages');
    }
};
