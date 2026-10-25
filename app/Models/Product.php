<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Brand (Satu produk milik satu brand)
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relasi ke Category (Satu produk milik satu kategori)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke ProductVariant (Satu produk bisa punya banyak varian ukuran/ml)
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Relasi ke FragranceNote (Satu produk bisa punya banyak catatan aroma)
    public function fragranceNotes(): HasMany
    {
        return $this->hasMany(FragranceNote::class);
    }

    // Relasi ke Review (Satu produk bisa punya banyak ulasan)
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
