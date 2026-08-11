<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id, 
                    'size_label' => 'Small (12cm pot)',
                ],
                [
                    'price' => $product->price,
                    'stock_qty' => 15,
                    'low_stock_threshold' => 5,
                    'stock_status' => 'In Stock',
                ]
            );

            ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id, 
                    'size_label' => 'Medium (17cm pot)',
                ],
                [
                    'price' => $product->price + 5.00,
                    'stock_qty' => 10,
                    'low_stock_threshold' => 5,
                    'stock_status' => 'In Stock',
                ]
            );

            ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id, 
                    'size_label' => 'Large (21cm pot)',
                ],
                [
                    'price' => $product->price + 12.00,
                    'stock_qty' => 5,
                    'low_stock_threshold' => 5,
                    'stock_status' => 'In Stock',
                ]
            );
        }
    }
}