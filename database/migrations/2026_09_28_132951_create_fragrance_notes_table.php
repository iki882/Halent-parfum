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
        Schema::create('fragrance_notes', function (Blueprint $table) {
            $table->id();
            // Menghubungkan note aroma ini ke produk parfum tertentu
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Menentukan jenis note: 'top', 'middle', atau 'base'
            $table->string('type');

            // Nama bahan aroma (contoh: Bergamot, Lavender, Vanilla, Amber)
            $table->string('name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fragrance_notes');
    }
};
