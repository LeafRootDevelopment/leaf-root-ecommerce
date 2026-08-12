<?php

namespace App\Http\Controllers;

use App\Actions\ProcessCheckoutAction;
use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Basket;
use App\Models\Order;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Store the completed order.
     */
    public function store(
        StoreCheckoutRequest $request, 
        ProcessCheckoutAction $processCheckout
    ): RedirectResponse {
        $basket = $this->getBasket($request);

        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('basket.index')
                ->with('error', 'Your basket is empty. Order could not be processed.');
        }

        try {
            // $request->validated() returns ONLY the fields that passed validation
            $order = $processCheckout->execute($basket, $request->validated(), $request);
        } catch (Exception $e) {
            return redirect()->route('basket.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('checkout.confirmation', $order)
            ->with('success', 'Thank you! Your order has been placed successfully.');
    }

    /**
     * Display order confirmation screen.
     */
    public function confirmation(Order $order): View
    {
        $order->load(['items.product', 'user', 'address']);

        return view('checkout.confirmation', compact('order'));
    }

    /**
     * Helper to retrieve current session basket.
     */
    private function getBasket(Request $request): ?Basket
    {
        $query = Basket::query();

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', $request->session()->getId());
        }

return $query->with('items.product')->first();
    }
}