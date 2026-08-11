<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test adding an in-stock product to the basket succeeds.
     */
    public function test_adding_in_stock_product_to_basket_succeeds(): void
    {
        $product = Product::factory()->create([
            'stock' => 10,
        ]);

        $response = $this->post(route('basket.store'), [
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test adding a quantity exceeding available stock fails validation.
     */
    public function test_adding_quantity_exceeding_stock_fails_validation(): void
    {
        $product = Product::factory()->create([
            'stock' => 5,
        ]);

        $response = $this->post(route('basket.store'), [
            'product_id' => $product->id,
            'quantity'   => 10,
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    /**
     * Test successful checkout decrements product stock correctly using HTTP customer flow.
     */
    public function test_checkout_decrements_product_stock_correctly(): void
    {
        // 1. Arrange: Create a product with 10 items in stock
        $product = Product::factory()->create([
            'name'  => 'Snake Plant',
            'price' => 15.00,
            'stock' => 10,
        ]);

        // 2. Act Step A: Add product to basket using real HTTP endpoint (establishes active session)
        $this->post(route('basket.store'), [
            'product_id' => $product->id,
            'quantity'   => 3,
        ])->assertStatus(200);

        // 3. Act Step B: Submit checkout payload across the same active HTTP session
        $response = $this->post(route('checkout.store'), [
            'first_name'     => 'Jane',
            'last_name'      => 'Doe',
            'email'          => 'jane@example.com',
            'address_line1'  => '123 Plant Street',
            'city'           => 'London',
            'postal_code'    => 'SW1A 1AA',
            'country'        => 'UK',
        ]);

        $response->assertSessionHasNoErrors();

        // 4. Assert: Product stock in database reflects decrement (10 - 3 = 7)
        $this->assertDatabaseHas('products', [
            'id'    => $product->id,
            'stock' => 7,
        ]);
    }
}