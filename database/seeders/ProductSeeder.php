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
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $indoorPlants?->id,
                'name'        => 'Snake Plant',
                'slug'        => 'snake-plant',
                'description' => 'Low maintenance indoor plant known for air purification.',
                'price'       => 18.50,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $indoorPlants?->id,
                'name'        => 'Peace Lily Premium',
                'slug'        => 'peace-lily-premium',
                'description' => 'Elegant indoor plant known for its air-purifying qualities.',
                'price'       => 24.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $indoorPlants?->id,
                'name'        => 'Spider Plant',
                'slug'        => 'spider-plant',
                'description' => 'Popular indoor plant with long arching leaves and excellent air-purifying qualities.',
                'price'       => 12.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $indoorPlants?->id,
                'name'        => 'ZZ Plant',
                'slug'        => 'zz-plant',
                'description' => 'The ZZ Plant is a low-maintenance houseplant with glossy dark green leaves. It is highly tolerant of low light conditions and requires infrequent watering, making it ideal for homes and offices.',
                'price'       => 24.99,
                'stock'       => 10,
                'is_active'   => true,
            ],

            // Succulents
            [
                'category_id' => $succulents?->id,
                'name'        => 'Aloe Vera',
                'slug'        => 'aloe-vera',
                'description' => 'Easy to care for succulent with soothing gel.',
                'price'       => 12.00,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $succulents?->id,
                'name'        => 'Jade Plant',
                'slug'        => 'jade-plant',
                'description' => 'Compact succulent with thick leaves, often called money plant.',
                'price'       => 14.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $succulents?->id,
                'name'        => 'Echeveria',
                'slug'        => 'echeveria',
                'description' => 'Compact rosette-shaped succulent available in a range of attractive colours.',
                'price'       => 5.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $succulents?->id,
                'name'        => 'Haworthia',
                'slug'        => 'haworthia',
                'description' => 'Small succulent with textured leaves and minimal watering requirements.',
                'price'       => 6.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $succulents?->id,
                'name'        => 'Burro\'s Tail',
                'slug'        => 'burros-tail',
                'description' => 'Trailing succulent ideal for hanging baskets and indoor displays.',
                'price'       => 11.99,
                'stock'       => 10,
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
            [
                'category_id' => $cacti?->id,
                'name'        => 'Saguaro Cactus',
                'slug'        => 'saguaro-cactus',
                'description' => 'Iconic desert cactus known for its tall upright growth habit.',
                'price'       => 18.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $cacti?->id,
                'name'        => 'Moon Cactus',
                'slug'        => 'moon-cactus',
                'description' => 'Colourful grafted cactus popular as an ornamental indoor plant.',
                'price'       => 9.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $cacti?->id,
                'name'        => 'Old Man Cactus',
                'slug'        => 'old-man-cactus',
                'description' => 'Slow-growing cactus covered with distinctive white hair-like spines.',
                'price'       => 13.99,
                'stock'       => 10,
                'is_active'   => true,
            ],

            // Pots
            [
                'category_id' => $pots?->id,
                'name'        => 'Ceramic Pot',
                'slug'        => 'ceramic-pot',
                'description' => 'Modern glazed ceramic plant pot.',
                'price'       => 15.00,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $pots?->id,
                'name'        => 'Terracotta Pot',
                'slug'        => 'terracotta-pot',
                'description' => 'Traditional breathable terracotta planter.',
                'price'       => 8.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $pots?->id,
                'name'        => 'Concrete Planter',
                'slug'        => 'concrete-planter',
                'description' => 'Modern planter with a durable minimalist concrete finish.',
                'price'       => 19.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $pots?->id,
                'name'        => 'Hanging Pot',
                'slug'        => 'hanging-pot',
                'description' => 'Decorative hanging planter ideal for displaying trailing plants.',
                'price'       => 14.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $pots?->id,
                'name'        => 'Self-Watering Pot',
                'slug'        => 'self-watering-pot',
                'description' => 'Planter with a built-in water reservoir to reduce maintenance.',
                'price'       => 24.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            // Accessories
            [
                'category_id' => $accessories?->id,
                'name'        => 'Plant Mister',
                'slug'        => 'plant-mister',
                'description' => 'Fine mist spray bottle for tropical humidity lovers.',
                'price'       => 9.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $accessories?->id,
                'name'        => 'Plant Food',
                'slug'        => 'plant-food',
                'description' => 'Nutrient-rich liquid fertiliser for vibrant houseplant growth.',
                'price'       => 7.50,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $accessories?->id,
                'name'        => 'Pruning Shears',
                'slug'        => 'pruning-shears',
                'description' => 'Precision gardening tool for trimming plants and maintaining growth.',
                'price'       => 11.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $accessories?->id,
                'name'        => 'Watering Can',
                'slug'        => 'watering-can',
                'description' => 'Lightweight watering can designed for indoor and outdoor plants.',
                'price'       => 9.99,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $accessories?->id,
                'name'        => 'Moisture Meter',
                'slug'        => 'moisture-meter',
                'description' => 'Simple gardening tool used to monitor soil moisture levels accurately.',
                'price'       => 12.99,
                'stock'       => 10,
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















