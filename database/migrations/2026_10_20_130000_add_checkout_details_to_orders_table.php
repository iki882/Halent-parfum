<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->string('customer_name')->nullable();
            $table->string('customer_whatsapp', 20)->nullable();
            $table->string('customer_email')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment_method')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_fee',
                'customer_name',
                'customer_whatsapp',
                'customer_email',
                'notes',
                'payment_method',
            ]);
        });
    }
};
