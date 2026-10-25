<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Properti yang boleh diisi secara massal saat form checkout dikirim
    protected $fillable = [
        'user_id',
        'order_number',
        'product_name',   // Diperbaiki dari produk_name agar sinkron dengan database
        'price',          // Ditambahkan agar harga satuan tersimpan
        'total_price',
        'total_payment',  // Ditambahkan agar total bayar terbaca di Filament admin
        'shipping_fee',
        'customer_name',
        'customer_whatsapp',
        'customer_email',
        'shipping_address',
        'notes',
        'payment_method',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
