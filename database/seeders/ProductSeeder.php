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
                'price' => 24.99,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $indoorPlants->id,
                'name' => 'Snake Plant',
                'slug' => 'snake-plant',
                'description' => 'Low maintenance indoor plant.',
                'price' => 18.50,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $succulents->id,
                'name' => 'Aloe Vera',
                'slug' => 'aloe-vera',
                'description' => 'Easy to care for succulent.',
                'price' => 9.99,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $succulents->id,
                'name' => 'Jade Plant',
                'slug' => 'jade-plant',
                'description' => 'Compact succulent with thick leaves.',
                'price' => 12.00,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => $cacti->id,
                'name' => 'Golden Barrel Cactus',
                'slug' => 'golden-barrel-cactus',
                'description' => 'Round cactus with golden spines.',
                'price' => 15.75,
                'stock' => 18,
                'is_active' => true,
            ],
            [
                'category_id' => $cacti->id,
                'name' => 'Bunny Ear Cactus',
                'slug' => 'bunny-ear-cactus',
                'description' => 'Popular cactus with distinctive pads.',
                'price' => 14.25,
                'stock' => 22,
                'is_active' => true,
            ],
            [
                'category_id' => $pots->id,
                'name' => 'Ceramic Pot',
                'slug' => 'ceramic-pot',
                'description' => 'Modern ceramic plant pot.',
                'price' => 19.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_id' => $pots->id,
                'name' => 'Terracotta Pot',
                'slug' => 'terracotta-pot',
                'description' => 'Traditional terracotta planter.',
                'price' => 11.50,
                'stock' => 35,
                'is_active' => true,
            ],
            [
                'category_id' => $accessories->id,
                'name' => 'Plant Mister',
                'slug' => 'plant-mister',
                'description' => 'Fine mist spray bottle for plants.',
                'price' => 7.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $accessories->id,
                'name' => 'Plant Food',
                'slug' => 'plant-food',
                'description' => 'Liquid fertiliser for houseplants.',
                'price' => 6.50,
                'stock' => 60,
                'is_active' => true,
            ],
        ]);
    }
}