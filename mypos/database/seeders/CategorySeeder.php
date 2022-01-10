<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Beverages',
            ],
            [
                'name' => 'Foods',
            ],
            [
                'name' => 'Medicines',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        };
    }
}
