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
                'name' => 'Pepsi',
                'description' => 'Soda',
                'image' => 'default.png',
                'purchase_price' => 2,
                'sale_price' => 5,
                'stock' => 100,
            ],
            [
                'category_id' => 1,
                'name' => 'Qahwah',
                'description' => "Coffee",
                'image' => 'default.png',
                'purchase_price' => 7,
                'sale_price' => 15,
                'stock' => 100,
            ],
            [
                'category_id' => 2,
                'name' => 'Kabsah',
                'description' => 'Saudi Rice',
                'image' => 'default.png',
                'purchase_price' => 40,
                'sale_price' => 130,
                'stock' => 100,
            ],
            [
                'category_id' => 2,
                'name' => 'Basbusah',
                'description' => 'Hijazi Dessert',
                'image' => 'default.png',
                'purchase_price' => 10,
                'sale_price' => 25,
                'stock' => 100,
            ],
            [
                'category_id' => 3,
                'name' => 'Panadol',
                'description' => 'Headache Medicine',
                'image' => 'default.png',
                'purchase_price' => 15,
                'sale_price' => 37,
                'stock' => 100,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
