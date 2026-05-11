<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'nama_produk' => 'Hoodie Nike Vintage',
                'brand'       => 'Nike',
                'deskripsi'   => 'Hoodie vintage kondisi bagus',
                'harga'       => 150000,
                'stok'        => 1,
                'ukuran'      => 'L',
                'warna'       => 'Hitam',
                'gender'      => 'unisex',
                'is_discount' => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'category_id' => 2,
                'nama_produk' => 'Flannel Zara Check',
                'brand'       => 'Zara',
                'deskripsi'   => 'Flannel kotak-kotak kondisi layak',
                'harga'       => 85000,
                'stok'        => 1,
                'ukuran'      => 'M',
                'warna'       => 'Merah',
                'gender'      => 'pria',
                'is_discount' => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}