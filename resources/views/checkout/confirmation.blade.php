@extends('layouts.customer')

@section('title', 'Order Confirmation - Leaf & Root')

@section('content')

    <div class="alert alert-success d-flex align-items-center p-3 mb-4 shadow-sm" role="alert">
        <svg class="bi flex-shrink-0 me-3" width="24" height="24" role="img" aria-label="Success:" viewBox="0 0 16 16" fill="currentColor">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l5.0-5.5a.75.75 0 0 0-.012-1.056z"/>
        </svg>
        <div>
            <h4 class="alert-heading mb-1">Order Confirmed!</h4>
            <p class="mb-0">
                Thank you, <strong>{{ $order->first_name }}</strong>! Your order <strong>#{{ $order->id }}</strong> has been placed successfully.
            </p>
        </div>
    </div>

    <div class="row g-4 mb-4">

        {{-- Order Metadata & Customer Information --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Order Reference:</strong> <span class="badge bg-secondary">#{{ $order->id }}</span></li>
                        <li class="mb-2"><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</li>
                        <li class="mb-0"><strong>Email:</strong> {{ $order->email }}</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Delivery Address --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">Delivery Address</h5>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}<br>
                        {{ $order->postcode }}
                    </address>
                </div>
            </div>
        </div>

    </div>

    {{-- Items Ordered Breakdown --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Items Ordered</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Product</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-end pe-4">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="ps-4 fw-medium">
                                {{ $item->product?->name ?? 'Unavailable Product' }}
                            </td>
                            <td class="text-end">
                                £{{ number_format($item->price, 2) }}
                            </td>
                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-end pe-4 fw-bold">
                                £{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Order Total & Continue CTA --}}
    <div class="d-flex justify-content-between align-items-center pt-2">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
            &larr; Continue Shopping
        </a>
        <div class="text-end">
            <span class="fs-5 text-muted me-2">Total Paid:</span>
            <span class="fs-2 fw-bold text-success">£{{ number_format($order->total, 2) }}</span>
        </div>
    </div>

@endsection