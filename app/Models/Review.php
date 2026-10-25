<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = ['id'];

    // Relasi: Setiap ulasan ditulis oleh satu pengguna (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Setiap ulasan ditujukan untuk satu produk parfum
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
