<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory()
            ->count(250)
            ->has(Attribute::factory()->count(20))
            ->create();
    }
}
