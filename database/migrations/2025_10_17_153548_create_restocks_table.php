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
        Schema::create('restocks', function (Blueprint $table) {
            $table->id();
            $table->string('restock_number')->unique(); // Nomor unik pembelian
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('purchase_date'); // Tanggal pembelian
            $table->decimal('total_amount', 15, 2); // Total pembelian
            $table->enum('payment_status', ['belum_dibayar', 'dibayar', 'gagal'])->default('belum_dibayar'); // Status pembayaran
            $table->enum('payment_method', ['cash', 'transfer', 'qris'])->nullable(); // Metode pembayaran
            $table->decimal('received_amount', 15, 2)->nullable(); // Jumlah uang yang diterima (untuk cash)
            $table->decimal('change_amount', 15, 2)->nullable(); // Kembalian (untuk cash)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
