<?php

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_in_stock_product_to_basket_succeeds(): void
    {
        $product = Product::factory()->create([
            'name' => 'Fiddle Leaf Fig',
            'stock' => 5,
        ]);

        $response = $this->post(route('basket.add', $product), [
            'quantity' => 2,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('basket_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_adding_quantity_exceeding_stock_fails_validation(): void
    {
        $product = Product::factory()->create([
            'name' => 'Monster Monstera',
            'stock' => 2,
        ]);

        $response = $this->from(route('products.index'))
            ->post(route('basket.add', $product), [
                'quantity' => 5,
            ]);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHasErrors('quantity');
    }

    public function test_checkout_decrements_product_stock_correctly(): void
    {
        $product = Product::factory()->create([
            'name' => 'Snake Plant',
            'price' => 15.00,
            'stock' => 10,
        ]);

        $basket = Basket::create(['session_id' => 'test-session-123']);
        BasketItem::create([
            'basket_id' => $basket->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response = $this->withSession(['_token' => 'test', 'session_id' => 'test-session-123'])
            ->post(route('checkout.store'), [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane@example.com',
                'address' => '123 Plant Street',
                'city' => 'London',
                'postcode' => 'SW1A 1AA',
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7,
        ]);
    }
}