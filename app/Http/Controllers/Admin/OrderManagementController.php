<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderManagementController extends Controller
{
    /**
     * Display a paginated listing of orders with search filtering.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $orders = Order::search($search)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'search'));
    }

    /**
     * Display order details with eager-loaded items and products.
     */
    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of a specific order.
     */
    public function updateStatus(
        UpdateOrderStatusRequest $request,
        Order $order
    ): RedirectResponse {
        $order->update([
            'status' => $request->validated()['status'],
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }
}