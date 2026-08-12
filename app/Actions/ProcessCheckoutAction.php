<?php

namespace App\Actions;

use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessCheckoutAction
{
    /**
     * Process checkout in a single database transaction with pessimistic locking.
     *
     * @throws Exception
     */
    public function execute(Basket $basket, array $validatedData, Request $request): Order
    {
        return DB::transaction(function () use ($basket, $validatedData, $request) {
            // 1. Verify and lock product rows for update to prevent race conditions
            foreach ($basket->items as $item) {
                $product = Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product && isset($product->stock) && $product->stock < $item->quantity) {
                    throw new Exception("Insufficient stock for '{$product->name}'. Available: {$product->stock}, Requested: {$item->quantity}.");
                }
            }

            $total = $basket->items->sum(function ($item) {
                return ($item->product->price ?? 0) * $item->quantity;
            });

            // 2. Create the Order
            $order = Order::create([
                'user_id'    => auth()->id(),
                'first_name' => $validatedData['first_name'],
                'last_name'  => $validatedData['last_name'],
                'email'      => $validatedData['email'],
                'phone'      => $validatedData['phone'] ?? null,
                'address'    => $validatedData['address'],
                'city'       => $validatedData['city'],
                'postcode'   => strtoupper($validatedData['postcode']),
                'total'      => $total,
                'status'     => 'pending',
            ]);

            // 3. Create OrderItems and decrement stock safely
            foreach ($basket->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->product->price,
                    'quantity'   => $item->quantity,
                ]);

                if (isset($item->product->stock)) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // 4. Clear Basket and Session Data
            $basket->items()->delete();
            $basket->delete();
            $request->session()->forget('basket_id');

            return $order;
        });
    }
}