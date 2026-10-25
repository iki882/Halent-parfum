<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $guarded = ['id'];

    // Relasi: Setiap varian ukuran dimiliki oleh satu produk parfum
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
