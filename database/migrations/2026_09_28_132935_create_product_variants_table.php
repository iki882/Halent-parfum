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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            // Menghubungkan varian ke tabel products (Parfum induknya)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Nama varian atau ukuran (contoh: "30ml", "50ml", "100ml")
            $table->string('variant_name');

            // Harga khusus untuk varian ukuran tersebut
            $table->decimal('price', 12, 2);

            // Stok khusus untuk varian ukuran tersebut
            $table->integer('stock')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
