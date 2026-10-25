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
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'product_name')) {
                $table->string('product_name')->nullable();
            }
            if (! Schema::hasColumn('orders', 'price')) {
                $table->integer('price')->nullable();
            }
            if (! Schema::hasColumn('orders', 'total_price')) {
                $table->integer('total_price')->nullable();
            }
            if (! Schema::hasColumn('orders', 'total_payment')) {
                $table->integer('total_payment')->nullable();
            }
            if (! Schema::hasColumn('orders', 'shipping_fee')) {
                $table->integer('shipping_fee')->default(15000)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'price', 'total_price', 'total_payment', 'shipping_fee']);
        });
    }
};
