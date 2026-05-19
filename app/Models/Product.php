<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'nama_produk',
        'brand',
        'deskripsi',
        'harga',
        'stok',
        'ukuran',
        'warna',
        'gender',
        'gambar',
        'is_discount',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}