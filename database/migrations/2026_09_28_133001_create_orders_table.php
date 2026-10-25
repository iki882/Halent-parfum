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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pesanan ke tabel users (siapa yang memesan)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Nomor atau kode transaksi unik (contoh: ORD-20261019-001)
            $table->string('order_number')->unique();

            $table->decimal('total_price', 12, 2);

            // Status pesanan (contoh: pending, processing, completed, cancelled)
            $table->string('status')->default('pending');

            // Alamat pengiriman lengkap
            $table->text('shipping_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
