<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Melindungi kolom id agar aman saat proses input data
    protected $guarded = ['id'];

    // Relasi: Satu brand memiliki banyak produk parfum
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
