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
        $succulents = Category::where('slug', 'succulents')->first();
        $cacti = Category::where('slug', 'cacti')->first();
        $pots = Category::where('slug', 'pots')->first();
        $accessories = Category::where('slug', 'accessories')->first();

        Product::insert([
            [
                'category_id' => $indoorPlants->id,
                'name' => 'Monstera Deliciosa',
                'slug' => 'monstera-deliciosa',
                'description' => 'Popular tropical indoor plant.',
                'is_active' => true,
            ],
            [
                'category_id' => $indoorPlants->id,
                'name' => 'Snake Plant',
                'slug' => 'snake-plant',
                'description' => 'Low maintenance indoor plant.',
                'is_active' => true,
            ],
            [
                'category_id' => $succulents->id,
                'name' => 'Aloe Vera',
                'slug' => 'aloe-vera',
                'description' => 'Easy to care for succulent.',
                'is_active' => true,
            ],
            [
                'category_id' => $succulents->id,
                'name' => 'Jade Plant',
                'slug' => 'jade-plant',
                'description' => 'Compact succulent with thick leaves.',
                'is_active' => true,
            ],
            [
                'category_id' => $cacti->id,
                'name' => 'Golden Barrel Cactus',
                'slug' => 'golden-barrel-cactus',
                'description' => 'Round cactus with golden spines.',
                'is_active' => true,
            ],
            [
                'category_id' => $cacti->id,
                'name' => 'Bunny Ear Cactus',
                'slug' => 'bunny-ear-cactus',
                'description' => 'Popular cactus with distinctive pads.',
                'is_active' => true,
            ],
            [
                'category_id' => $pots->id,
                'name' => 'Ceramic Pot',
                'slug' => 'ceramic-pot',
                'description' => 'Modern ceramic plant pot.',
                'is_active' => true,
            ],
            [
                'category_id' => $pots->id,
                'name' => 'Terracotta Pot',
                'slug' => 'terracotta-pot',
                'description' => 'Traditional terracotta planter.',
                'is_active' => true,
            ],
            [
                'category_id' => $accessories->id,
                'name' => 'Plant Mister',
                'slug' => 'plant-mister',
                'description' => 'Fine mist spray bottle for plants.',
                'is_active' => true,
            ],
            [
                'category_id' => $accessories->id,
                'name' => 'Plant Food',
                'slug' => 'plant-food',
                'description' => 'Liquid fertiliser for houseplants.',
                'is_active' => true,
            ],
        ]);
    }
}