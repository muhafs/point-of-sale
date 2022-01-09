<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            Client::create([
                'name' => Str::random(5),
                'phone' => rand(100, 200),
                'address' => Str::random(10),
            ]);
        }
    }
}
