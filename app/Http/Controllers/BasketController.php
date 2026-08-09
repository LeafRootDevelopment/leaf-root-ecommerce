<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BasketController extends Controller
{
    /**
     * Display the current basket.
     */
    public function index(): View
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
    public function add(Request $request, Product $product): RedirectResponse
    {
        // 1. Validate the submitted quantity from the form
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $quantity = (int) $validated['quantity'];

        // 2. Find or create the basket for the active session
        $basket = Basket::firstOrCreate([
            'session_id' => session()->getId(),
        ]);

        // 3. Find existing basket item or create a new line item
        $basketItem = BasketItem::where('basket_id', $basket->id)
            ->where('product_id', $product->id)
            ->first();

        if ($basketItem) {
            $basketItem->increment('quantity', $quantity);
        } else {
            BasketItem::create([
                'basket_id' => $basket->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        // 4. Redirect to basket view with feedback message
        return redirect()
            ->route('basket.index')
            ->with('success', "{$product->name} (x{$quantity}) added to your basket successfully.");
    }

    /**
     * Update basket item quantity.
     */
    public function update(Request $request, BasketItem $basketItem): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $basketItem->update([
            'quantity' => $validated['quantity'],
        ]);

        return redirect()
            ->route('basket.index')
            ->with('success', 'Basket updated successfully.');
    }

    /**
     * Remove an item from the basket.
     */
    public function remove(BasketItem $basketItem): RedirectResponse
    {
        $basketItem->delete();

        return redirect()
            ->route('basket.index')
            ->with('success', 'Product removed from basket successfully.');
    }
}