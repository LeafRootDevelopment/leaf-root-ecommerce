<?php

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_checkout_creates_order_and_clears_basket(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'price' => 25.00,
            'stock' => 10,
        ]);

        $basket = Basket::create([
            'user_id' => $user->id,
        ]);

        BasketItem::create([
            'basket_id'  => $basket->id,
            'product_id' => $product->id,
            'quantity'   => 2,
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
        $response->assertRedirect();

        $this->assertDatabaseHas('addresses', [
            'address_line1' => '123 Plant Street',
            'city'          => 'London',
            'postal_code'   => 'SW1A 1AA',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total'   => 50.00,
        ]);

        $this->assertDatabaseHas('products', [
            'id'    => $product->id,
            'stock' => 8,
        ]);

        $this->assertDatabaseCount('basket_items', 0);
        $this->assertDatabaseCount('baskets', 0);
    }

    public function test_authenticated_user_checkout_links_to_user_account(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'price' => 50.00,
            'stock' => 5,
        ]);

        $basket = Basket::create([
            'user_id' => $user->id,
        ]);

        BasketItem::create([
            'basket_id'  => $basket->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('checkout.store'), [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => $user->email,
                'phone'      => '07123456789',
                'address'    => '456 Garden Way',
                'city'       => 'Manchester',
                'postcode'   => 'M1 1AA',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total'   => 50.00,
        ]);
    }

    public function test_checkout_fails_validation_when_required_fields_missing(): void
    {
        $product = Product::factory()->create([
            'stock' => 10,
        ]);

        $this->post(route('basket.add', $product), [
            'quantity' => 1,
        ]);

        $response = $this->post(route('checkout.store'), [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'city'       => 'London',
        ]);

        $response->assertSessionHasErrors([
            'email',
            'address',
            'postcode',
        ]);

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 10,
        ]);
    }

    public function test_checkout_fails_if_basket_is_empty(): void
    {
        $response = $this->post(route('checkout.store'), [
            'first_name' => 'Jane',
            'last_name'  => 'Doe',
            'email'      => 'jane@example.com',
            'address'    => '123 Plant Street',
            'city'       => 'London',
            'postcode'   => 'SW1A 1AA',
        ]);

        $response->assertRedirect(route('basket.index'));
        $response->assertSessionHas('error');
    }
}