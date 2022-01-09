<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
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
        for ($i = 0; $i < 4; $i++) {
            Product::create([
                'category_id' => rand(1, 2),
                'name' => Str::random(5),
                'description' => Str::random(10),
                'image' => 'default.png',
                'purchase_price' => rand(1000, 25000),
                'sale_price' => rand(40000, 100000),
                'stock' => rand(10, 100),
            ]);
        }
    }
}
