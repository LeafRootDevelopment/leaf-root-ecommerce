<?php

namespace App\Providers;

use App\Models\Basket;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share active basket count with the customer layout across all routes
        View::composer('layouts.customer', function ($view) {
            $sessionId = session()->getId();
            $basketCount = 0;

            if ($sessionId) {
                $basket = Basket::where('session_id', $sessionId)
                    ->with('items')
                    ->first();

                if ($basket) {
                    $basketCount = (int) $basket->items->sum('quantity');
                }
            }

            $view->with('basketCount', $basketCount);
        });
    }
}