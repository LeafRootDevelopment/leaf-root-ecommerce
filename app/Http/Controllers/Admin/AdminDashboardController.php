<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard metrics.
     */
    public function index(): View
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $orderCount = Order::count();

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'orderCount'
        ));
    }
}