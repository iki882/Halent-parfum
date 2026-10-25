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
            // Tambahkan kolom tanpa opsi ->after() untuk menghindari error kolom acuan
            if (! Schema::hasColumn('orders', 'total_payment')) {
                $table->integer('total_payment')->nullable();
            }
            if (! Schema::hasColumn('orders', 'price')) {
                $table->integer('price')->nullable();
            }
            if (! Schema::hasColumn('orders', 'shipping_fee')) {
                $table->integer('shipping_fee')->default(15000)->nullable();
            }
            if (! Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (! Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['total_payment', 'price', 'shipping_fee', 'payment_method', 'notes']);
        });
    }
};
