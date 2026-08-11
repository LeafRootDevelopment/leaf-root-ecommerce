<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $indoorPlants = Category::where('slug', 'indoor-plants')->first();
        $succulents   = Category::where('slug', 'succulents')->first();
        $cacti        = Category::where('slug', 'cacti')->first();
        $pots         = Category::where('slug', 'pots')->first();
        $accessories  = Category::where('slug', 'accessories')->first();

        $products = [
            // Indoor Plants
            [
                'category_id' => $indoorPlants?->id,
                'name'        => 'Monstera Deliciosa',
                'slug'        => 'monstera-deliciosa',
                'description' => 'Popular tropical indoor plant with iconic split leaves.',
                'price'       => 24.99,
                'stock'       => 15,
                'is_active'   => true,
            ],
            [
                'category_id' => $indoorPlants?->id,
                'name'        => 'Snake Plant',
                'slug'        => 'snake-plant',
                'description' => 'Low maintenance indoor plant known for air purification.',
                'price'       => 18.50,
                'stock'       => 20,
                'is_active'   => true,
            ],

            // Succulents
            [
                'category_id' => $succulents?->id,
                'name'        => 'Aloe Vera',
                'slug'        => 'aloe-vera',
                'description' => 'Easy to care for succulent with soothing gel.',
                'price'       => 12.00,
                'stock'       => 25,
                'is_active'   => true,
            ],
            [
                'category_id' => $succulents?->id,
                'name'        => 'Jade Plant',
                'slug'        => 'jade-plant',
                'description' => 'Compact succulent with thick leaves, often called money plant.',
                'price'       => 14.99,
                'stock'       => 18,
                'is_active'   => true,
            ],

            // Cacti
            [
                'category_id' => $cacti?->id,
                'name'        => 'Golden Barrel Cactus',
                'slug'        => 'golden-barrel-cactus',
                'description' => 'Round cactus with striking golden spines.',
                'price'       => 16.00,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $cacti?->id,
                'name'        => 'Bunny Ear Cactus',
                'slug'        => 'bunny-ear-cactus',
                'description' => 'Popular cactus with distinctive pad shapes.',
                'price'       => 11.50,
                'stock'       => 12,
                'is_active'   => true,
            ],

            // Pots
            [
                'category_id' => $pots?->id,
                'name'        => 'Ceramic Pot',
                'slug'        => 'ceramic-pot',
                'description' => 'Modern glazed ceramic plant pot.',
                'price'       => 15.00,
                'stock'       => 30,
                'is_active'   => true,
            ],
            [
                'category_id' => $pots?->id,
                'name'        => 'Terracotta Pot',
                'slug'        => 'terracotta-pot',
                'description' => 'Traditional breathable terracotta planter.',
                'price'       => 8.99,
                'stock'       => 40,
                'is_active'   => true,
            ],

            // Accessories
            [
                'category_id' => $accessories?->id,
                'name'        => 'Plant Mister',
                'slug'        => 'plant-mister',
                'description' => 'Fine mist spray bottle for tropical humidity lovers.',
                'price'       => 9.99,
                'stock'       => 22,
                'is_active'   => true,
            ],
            [
                'category_id' => $accessories?->id,
                'name'        => 'Plant Food',
                'slug'        => 'plant-food',
                'description' => 'Nutrient-rich liquid fertiliser for vibrant houseplant growth.',
                'price'       => 7.50,
                'stock'       => 50,
                'is_active'   => true,
            ],
        ];

        foreach ($products as $product) {
            if ($product['category_id']) {
                Product::updateOrCreate(
                    ['slug' => $product['slug']],
                    $product
                );
            }
        }
    }
}