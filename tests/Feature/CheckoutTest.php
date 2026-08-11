<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest checkout creates order, address, order items, decrements stock, and clears basket.
     */
    public function test_guest_checkout_creates_order_and_clears_basket(): void
    {
        // 1. Arrange: Create two distinct products
        $productA = Product::factory()->create(['price' => 20.00, 'stock' => 10]);
        $productB = Product::factory()->create(['price' => 15.00, 'stock' => 5]);

        // Add items to basket via HTTP to establish active session
        $this->post(route('basket.store'), ['product_id' => $productA->id, 'quantity' => 2]);
        $this->post(route('basket.store'), ['product_id' => $productB->id, 'quantity' => 1]);

        $this->assertDatabaseHas('baskets', ['session_id' => session()->getId()]);

        // 2. Act: Submit guest checkout payload
        $checkoutData = [
            'first_name'     => 'Jane',
            'last_name'      => 'Doe',
            'email'          => 'jane.guest@example.com',
            'phone'          => '07123456789',
            'address_line1'  => '10 Green Lane',
            'address_line2'  => 'Apt 4B',
            'city'           => 'Manchester',
            'state_province' => 'Greater Manchester',
            'postal_code'    => 'M1 1AA',
            'country'        => 'UK',
        ];

        $response = $this->post(route('checkout.store'), $checkoutData);

        // 3. Assert: Validation passes and redirect succeeds
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        // 4. Assert: Address record created for guest
        $this->assertDatabaseHas('addresses', [
            'user_id'       => null,
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'address_line1' => '10 Green Lane',
            'city'          => 'Manchester',
            'postal_code'   => 'M1 1AA',
            'country'       => 'UK',
        ]);

        $address = Address::where('postal_code', 'M1 1AA')->first();

        // 5. Assert: Order record linked to address with user_id = null
        $this->assertDatabaseHas('orders', [
            'user_id'    => null,
            'address_id' => $address->id,
            'total'      => 55.00, // (20.00 * 2) + (15.00 * 1)
        ]);

        $order = Order::where('address_id', $address->id)->first();

        // 6. Assert: Order items saved with historical unit prices
        $this->assertDatabaseHas('order_items', [
            'order_id'   => $order->id,
            'product_id' => $productA->id,
            'quantity'   => 2,
            'unit_price' => 20.00,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id'   => $order->id,
            'product_id' => $productB->id,
            'quantity'   => 1,
            'unit_price' => 15.00,
        ]);

        // 7. Assert: Product stock decremented
        $this->assertDatabaseHas('products', ['id' => $productA->id, 'stock' => 8]);
        $this->assertDatabaseHas('products', ['id' => $productB->id, 'stock' => 4]);

        // 8. Assert: Basket cleared from database
        $this->assertDatabaseMissing('baskets', ['session_id' => session()->getId()]);
    }

    /**
     * Test authenticated user checkout links order and address to user account.
     */
    public function test_authenticated_user_checkout_links_to_user_account(): void
    {
        // 1. Arrange: Registered user and product
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name'  => 'Smith',
            'email'      => 'john.smith@example.com',
        ]);

        $product = Product::factory()->create(['price' => 30.00, 'stock' => 10]);

        // Authenticate user and add item to basket
        $this->actingAs($user);
        $this->post(route('basket.store'), ['product_id' => $product->id, 'quantity' => 2]);

        // 2. Act: Submit checkout while logged in
        $checkoutData = [
            'first_name'    => 'John',
            'last_name'     => 'Smith',
            'email'         => 'john.smith@example.com',
            'address_line1' => '45 Oak Road',
            'city'          => 'Birmingham',
            'postal_code'   => 'B1 1BB',
            'country'       => 'UK',
        ];

        $response = $this->post(route('checkout.store'), $checkoutData);

        $response->assertSessionHasNoErrors();

        // 3. Assert: Address belongs to user
        $this->assertDatabaseHas('addresses', [
            'user_id'       => $user->id,
            'address_line1' => '45 Oak Road',
            'postal_code'   => 'B1 1BB',
        ]);

        $address = Address::where('postal_code', 'B1 1BB')->first();

        // 4. Assert: Order belongs to user and linked address
        $this->assertDatabaseHas('orders', [
            'user_id'    => $user->id,
            'address_id' => $address->id,
            'total'      => 60.00,
        ]);

        // 5. Assert: Stock decremented
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 8]);
    }

    /**
     * Test checkout fails with validation errors when required fields are missing.
     */
    public function test_checkout_fails_validation_when_required_fields_missing(): void
    {
        $product = Product::factory()->create(['stock' => 10]);
        $this->post(route('basket.store'), ['product_id' => $product->id, 'quantity' => 1]);

        // Incomplete submission missing email, address_line1, and postal_code
        $response = $this->post(route('checkout.store'), [
            'first_name' => 'Jane',
            'last_name'  => 'Doe',
            'city'       => 'London',
        ]);

        $response->assertSessionHasErrors(['email', 'address_line1', 'postal_code']);

        // Database remains untouched
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 10]);
    }

    /**
     * Test checkout fails if basket is empty.
     */
    public function test_checkout_fails_if_basket_is_empty(): void
    {
        $response = $this->post(route('checkout.store'), [
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'email'         => 'jane@example.com',
            'address_line1' => '123 High Street',
            'city'          => 'Bristol',
            'postal_code'   => 'BS1 1AA',
            'country'       => 'UK',
        ]);

        $this->assertDatabaseCount('orders', 0);
    }
}