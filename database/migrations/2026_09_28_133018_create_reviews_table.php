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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ulasan dengan tabel users (siapa yang memberi ulasan)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Menghubungkan ulasan dengan tabel products (parfum apa yang diulas)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Kolom untuk rating (misalnya skala 1 sampai 5)
            $table->unsignedTinyInteger('rating');

            // Kolom untuk teks komentar atau ulasan
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
