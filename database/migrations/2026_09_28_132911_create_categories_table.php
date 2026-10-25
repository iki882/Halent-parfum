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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Nama kategori aroma (contoh: Woody, Floral, Fresh)
            $table->string('name');
            // Slug untuk URL (contoh: woody, floral)
            $table->string('slug')->unique();
            // Deskripsi singkat tentang karakteristik aroma tersebut
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
