<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Melindungi kolom id agar aman saat proses input data
    protected $guarded = ['id'];

    // Relasi: Satu kategori memiliki banyak produk parfum
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
