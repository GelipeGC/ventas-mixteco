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
            'name' => 'Fundas',
            'cost' => 12,
            'price' => 12,
            'barcode' => '1001',
            'stock' => 10000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'image.jpg'
        ]);
    }
}
