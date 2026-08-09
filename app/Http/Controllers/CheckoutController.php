<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form with order summary.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $basket = $this->getBasket($request);

        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('basket.index')
                ->with('error', 'Your basket is empty. Please add items before checking out.');
        }

        $total = $basket->items->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        return view('checkout.index', compact('basket', 'total'));
    }

    /**
     * Store the completed order and clear the active basket.
     */
    public function store(StoreCheckoutRequest $request): RedirectResponse
    {
        $basket = $this->getBasket($request);

        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('basket.index')
                ->with('error', 'Your basket is empty. Order could not be processed.');
        }

        $validated = $request->validated();

        $order = DB::transaction(function () use ($basket, $validated, $request) {
            $total = $basket->items->sum(function ($item) {
                return ($item->product->price ?? 0) * $item->quantity;
            });

            // 1. Create Order
            $order = Order::create([
                'user_id'     => auth()->id(),
                'first_name'  => $validated['first_name'],
                'last_name'   => $validated['last_name'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'] ?? null,
                'address'     => $validated['address'],
                'city'        => $validated['city'],
                'postcode'    => strtoupper($validated['postcode']),
                'total'       => $total,
                'status'      => 'pending',
            ]);

            // 2. Attach Order Items
            foreach ($basket->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->product->price,
                    'quantity'   => $item->quantity,
                ]);
            }

            // 3. Clear Basket Items & Remove Basket
            $basket->items()->delete();
            $basket->delete();
            $request->session()->forget('basket_id');

            return $order;
        });

        return redirect()->route('checkout.confirmation', $order)
            ->with('success', 'Thank you! Your order has been placed successfully.');
    }

    /**
     * Display order confirmation screen.
     */
    public function confirmation(Order $order): View
    {
        $order->load('items.product');

        return view('checkout.confirmation', compact('order'));
    }

    /**
     * Helper to retrieve current session basket.
     */
    private function getBasket(Request $request): ?Basket
    {
        return Basket::where(
            'session_id',
            $request->session()->getId()
            )->with('items.product')->first();
    }
}