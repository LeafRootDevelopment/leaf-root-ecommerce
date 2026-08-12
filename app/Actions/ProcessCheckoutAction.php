<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcessCheckoutAction
{
    public function execute(Basket $basket, array $validatedData, Request $request): Order
    {
        return DB::transaction(function () use ($basket, $validatedData, $request) {
            // 1. Get or create user
            $user = auth()->user();

            if (!$user) {
                $user = User::firstOrCreate(
                    ['email' => $validatedData['email']],
                    [
                        'first_name' => $validatedData['first_name'],
                        'last_name'  => $validatedData['last_name'],
                        'role'       => 'customer',
                        'password'   => bcrypt(Str::random(16)),
                    ]
                );
            }

            // 2. Map request fields to Address columns
            $address = Address::create([
                'user_id'       => $user->id,
                'address_line1' => $validatedData['address'],
                'city'          => $validatedData['city'],
                'postal_code'   => $validatedData['postcode'],
            ]);

            // 3. Calculate total
            $total = $basket->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // 4. Create Order
            $order = Order::create([
                'user_id'    => $user->id,
                'address_id' => $address->id,
                'total'      => $total,
                'status'     => 'pending',
            ]);

            // 5. Process items and decrement stock
            foreach ($basket->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                // Decrement stock directly on product
                $item->product->decrement('stock', $item->quantity);
            }

            // 6. Clear basket items & basket
            $basket->items()->delete();
            $basket->delete();

            return $order;
        });
    }
}