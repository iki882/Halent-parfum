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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            // Nama merek parfum (contoh: Chanel, Dior, Halent, dll.)
            $table->string('name');
            // Slug untuk URL yang ramah SEO (contoh: chanel, halent-parfume)
            $table->string('slug')->unique();
            // Logo atau gambar merek (opsional, menyimpan nama file gambar)
            $table->string('logo')->nullable();
            // Deskripsi singkat tentang brand tersebut
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
