<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

            // 2. Resolve User & Sync Submitted Contact Details
            $user = auth()->user();

            if ($user) {
                $user->update([
                    'first_name' => $validatedData['first_name'],
                    'last_name'  => $validatedData['last_name'],
                    'email'      => $validatedData['email'],
                    'phone'      => $validatedData['phone'] ?? $user->phone,
                ]);
            } else {
                $user = User::create([
                    'first_name' => $validatedData['first_name'],
                    'last_name'  => $validatedData['last_name'],
                    'email'      => $validatedData['email'],
                    'phone'      => $validatedData['phone'] ?? null,
                    'password'   => bcrypt(Str::random(16)),
                    'role'       => 'customer',
                ]);
            }

            // 3. Create or find the delivery Address record matching database column names
            $address = Address::create([
                'user_id'        => $user->id,
                'address_line1'  => $validatedData['address'],
                'address_line2'  => $validatedData['address_line2'] ?? null,
                'city'           => $validatedData['city'],
                'state_province' => null,
                'postal_code'    => strtoupper($validatedData['postcode']),
                'country'        => 'United Kingdom',
                'is_default'     => false,
            ]);

            // 4. Create the Order linked to User and Address
            $order = Order::create([
                'user_id'    => $user->id,
                'address_id' => $address->id,
                'total'      => $total,
                'status'     => 'pending',
            ]);

            // 5. Create OrderItems and decrement stock safely
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

            // 6. Clear Basket and Session Data
            $basket->items()->delete();
            $basket->delete();
            $request->session()->forget('basket_id');

            return $order;
        });
    }
}