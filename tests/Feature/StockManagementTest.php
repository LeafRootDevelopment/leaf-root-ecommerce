<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;



class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_in_stock_product_to_basket_succeeds(): void
    {
        $product = Product::factory()->create(['stock' => 10]);

        $response = $this->post(route('basket.add', $product), [
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_adding_quantity_exceeding_stock_fails_validation(): void
    {
        $product = Product::factory()->create(['stock' => 3]);

        $response = $this->post(route('basket.add', $product), [
            'quantity' => 5,
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_checkout_decrements_product_stock_correctly(): void
    {
        // 1. Arrange: Product with 10 items
        $product = Product::factory()->create(['stock' => 10, 'price' => 15.00]);

        // 2. Add via HTTP endpoint to establish active session
$user = User::factory()->create();

$basket = Basket::create([
    'user_id' => $user->id,
]);

BasketItem::create([
    'basket_id'  => $basket->id,
    'product_id' => $product->id,
    'quantity'   => 3,
]);

$response = $this
    ->actingAs($user)
    ->post(route('checkout.store'), [
        'first_name' => 'Jane',
        'last_name'  => 'Doe',
        'email'      => $user->email,
        'phone'      => '07123456789',
        'address'    => '123 Plant Street',
        'city'       => 'London',
        'postcode'   => 'SW1A 1AA',
    ]);
        $response->assertSessionHasNoErrors();

        // 4. Assert: Stock updated (10 - 3 = 7)
        $this->assertDatabaseHas('products', [
            'id'    => $product->id,
            'stock' => 7,
        ]);
    }
}