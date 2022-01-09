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
        $products = [
            [
                'category_id' => 1,
                'name' => 'Milk',
                'description' => 'Cow Milk',
                'image' => 'default.png',
                'purchase_price' => 18000,
                'sale_price' => 21000,
                'stock' => 100,
            ],
            [
                'category_id' => 1,
                'name' => 'Coffee',
                'description' => "Gayo's coffee",
                'image' => 'default.png',
                'purchase_price' => 9000,
                'sale_price' => 43000,
                'stock' => 100,
            ],
            [
                'category_id' => 2,
                'name' => 'Kabsah',
                'description' => 'Saudi rice',
                'image' => 'default.png',
                'purchase_price' => 40000,
                'sale_price' => 300000,
                'stock' => 100,
            ],
            [
                'category_id' => 2,
                'name' => 'Sate',
                'description' => 'Chicken tinder',
                'image' => 'default.png',
                'purchase_price' => 5000,
                'sale_price' => 12000,
                'stock' => 100,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
