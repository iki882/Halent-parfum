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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel orders (masuk ke pesanan nomor berapa)
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Menghubungkan ke tabel products (parfum apa yang dibeli)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Jumlah botol parfum yang dibeli untuk produk tersebut
            $table->integer('quantity');

            // Harga satuan parfum saat dibeli
            $table->decimal('price', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
