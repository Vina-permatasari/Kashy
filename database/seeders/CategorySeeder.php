<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Hoodie', 'Flannel', 'Celana',
            'Jaket', 'Kaos', 'Kemeja'
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'nama_kategori' => $cat,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}