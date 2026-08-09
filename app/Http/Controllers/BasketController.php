<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    /**
     * Display the current basket.
     */
    public function index()
    {
        $basket = Basket::where(
            'session_id',
            session()->getId()
        )->with('items.product')->first();

        $total = 0;

        if ($basket) {
            foreach ($basket->items as $item) {
                $total += ($item->product->price ?? 0) * $item->quantity;
            }
        }

        return view(
            'basket.index',
            compact('basket', 'total')
        );
    }

    /**
     * Add a product to the basket.
     */
    public function add(Product $product)
    {
        $basket = Basket::firstOrCreate([
            'session_id' => session()->getId(),
        ]);

        $basketItem = BasketItem::where(
            'basket_id',
            $basket->id
        )
        ->where(
            'product_id',
            $product->id
        )
        ->first();

        if ($basketItem) {
            $basketItem->increment('quantity');
        } else {
            BasketItem::create([
                'basket_id' => $basket->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()
            ->route('basket.index')
            ->with('success', 'Product added to basket successfully.');
    }

    /**
     * Update basket item quantity.
     */
    public function update(
        Request $request,
        BasketItem $basketItem
    ) {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $basketItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()
            ->route('basket.index')
            ->with('success', 'Basket updated successfully.');
   