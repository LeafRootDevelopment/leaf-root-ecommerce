<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Contact;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $orderCount = Order::count();
        $contactCount = Contact::count();

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'orderCount',
            'contactCount'
        ));
    }
}