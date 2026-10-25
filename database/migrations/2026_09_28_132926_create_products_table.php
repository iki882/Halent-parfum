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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Menghubungkan produk ke tabel brands (Merek parfum)
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');

            // Menghubungkan produk ke tabel categories (Kategori aroma)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Nama parfum (contoh: Bleu de Chanel, Sauvage, dll.)
            $table->string('name');

            // Slug untuk URL produk yang bersih
            $table->string('slug')->unique();

            // Deskripsi lengkap tentang aroma, ketahanan, dan keunggulan parfum
            $table->text('description')->nullable();

            // Harga produk
            $table->decimal('price', 12, 2);

            // Jumlah stok barang
            $table->integer('stock')->default(0);

            // Menyimpan nama file foto produk utama
            $table->string('image')->nullable();

            // Status produk aktif atau tidak (opsional, untuk menyembunyikan produk jika habis)
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
