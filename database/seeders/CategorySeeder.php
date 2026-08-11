<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Indoor Plants',
                'slug' => 'indoor-plants',
                'description' => 'Popular indoor houseplants.'
            ],
            [
                'name' => 'Succulents',
                'slug' => 'succulents',
                'description' => 'Low-maintenance succulent plants.'
            ],
            [
                'name' => 'Cacti',
                'slug' => 'cacti',
                'description' => 'Indoor and outdoor cactus plants.'
            ],
            [
                'name' => 'Pots',
                'slug' => 'pots',
                'description' => 'Pots and planters.'
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Plant care accessories.'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}