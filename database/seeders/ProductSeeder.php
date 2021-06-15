<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Pastor',
            'cost' => 12,
            'price' => 12,
            'barcode' => '1111',
            'stock' => 10000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'image.jpg'
        ]);
        Product::create([
            'name' => 'Bisteck',
            'cost' => 17,
            'price' => 17,
            'barcode' => '1111',
            'stock' => 10000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'image.jpg'
        ]);
    }
}
