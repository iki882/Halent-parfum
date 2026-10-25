<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FragranceNote extends Model
{
    protected $guarded = ['id'];

    // Relasi: Setiap catatan aroma dimiliki oleh satu produk parfum
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
