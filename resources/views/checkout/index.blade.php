@extends('layouts.customer')

@section('title', 'Checkout - Leaf & Root')

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1 fw-bold">Checkout</h1>
            <p class="text-muted small mb-0">Complete your delivery details to place your order</p>
        </div>
        <a href="{{ Route::has('basket.index') ? route('basket.index') : url('/basket') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Return to Basket
        </a>
    </div>

    @if (!$basket || $basket->items->isEmpty())
        
        {{-- Empty Basket Guard View --}}
        <div class="card shadow-sm border-0 text-center py-5 my-4">
            <div class="card-body p-5">
                <i class="bi bi-cart-x text-muted opacity-50 display-4 mb-3"></i>
                <h3 class="h4 card-title text-muted mb-2">Cannot Proceed to Checkout</h3>
                <p class="card-text text-secondary mb-4">Your shopping basket is currently empty. Please add items to your basket before checking out.</p>
                <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="btn btn-success px-4">
                    Explore Products &rarr;
                </a>
            </div>
        </div>

    @else

        {{-- Main Checkout Form Grid --}}
        @php
            $checkoutAction = Route::has('checkout.store') 
                ? route('checkout.store') 
                : (Route::has('orders.store') 
                    ? route('orders.store') 
                    : (Route::has('checkout.process') 
                        ? route('checkout.process') 
                        : url('/checkout')));
            
            $user = auth()->user();
            $defaultFirstName = old('first_name', $user?->first_name ?? '');
            $defaultLastName  = old('last_name', $user?->last_name ?? '');
            $defaultEmail     = old('email', $user?->email ?? '');
            $defaultPhone     = old('phone', $user?->phone ?? '');
        @endphp

        <form action="{{ $checkoutAction }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- Delivery Details & Payment Panel --}}
                <div class="col-lg-7">
                    
                    {{-- Section 1: Delivery Details --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h2 class="h5 card-title mb-0 fw-bold d-flex align-items-center">
                                <span class="badge bg-success me-2 rounded-circle fs-6">1</span>
                                Delivery Details
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">

                                {{-- First Name --}}
                                <div class="col-sm-6">
                                    <label for="first_name" class="form-label fw-medium">First Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ $defaultFirstName }}"
                                        autocomplete="given-name"
                                        required
                                    >
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Last Name --}}
                                <div class="col-sm-6">
                                    <label for="last_name" class="form-label fw-medium">Last Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ $defaultLastName }}"
                                        autocomplete="family-name"
                                        required
                                    >
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email Address --}}
                                <div class="col-12">
                                    <label for="email" class="form-label fw-medium">Email Address <span class="text-danger">*</span></label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ $defaultEmail }}"
                                        autocomplete="email"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone Number --}}
                                <div class="col-12">
                                    <label for="phone" class="form-label fw-medium">Phone Number <span class="text-muted font-normal">(Optional - for delivery updates)</span></label>
                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ $defaultPhone }}"
                                        autocomplete="tel"
                                    >
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Street Address --}}
                                <div class="col-12">
                                    <label for="address" class="form-label fw-medium">Street Address <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="address"
                                        name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address') }}"
                                        placeholder="House number and street name"
                                        autocomplete="street-address"
                                        required
                                    >
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- City --}}
                                <div class="col-sm-6">
                                    <label for="city" class="form-label fw-medium">City / Town <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city') }}"
                                        autocomplete="address-level2"
                                        required
                                    >
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Postcode --}}
                                <div class="col-sm-6">
                                    <label for="postcode" class="form-label fw-medium">Postcode <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="postcode"
                                        name="postcode"
                                        class="form-control @error('postcode') is-invalid @enderror"
                                        value="{{ old('postcode') }}"
                                        autocomplete="postal-code"
                                        required
                                    >
                                    @error('postcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Payment Method --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h2 class="h5 card-title mb-0 fw-bold d-flex align-items-center">
                                <span class="badge bg-success me-2 rounded-circle fs-6">2</span>
                                Payment Options
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-check p-3 border rounded mb-2 bg-light">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card" checked>
                                <label class="form-check-label fw-semibold d-flex justify-content-between align-items-center w-100 ms-2" for="payment_card">
                                    <span>Credit or Debit Card</span>
                                    <span class="text-muted small">Visa / Mastercard</span>
                                </label>
                            </div>

                            <div class="form-check p-3 border rounded bg-light">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod">
                                <label class="form-check-label fw-semibold d-flex justify-content-between align-items-center w-100 ms-2" for="payment_cod">
                                    <span>Pay on Delivery</span>
                                    <span class="text-muted small">Cash / Card on receipt</span>
                                </label>
                            </div>

                            @error('payment_method')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit Action --}}
                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow-sm mb-4">
                        Place Order &rarr;
                    </button>

                </div>

                {{-- Order Summary Sidebar --}}
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h2 class="h5 card-title mb-0 fw-bold">Order Summary</h2>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush mb-3">
                                @foreach ($basket->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                        <div class="me-3">
                                            <h6 class="my-0 fw-bold text-dark">{{ $item->product?->name ?? 'Product Item' }}</h6>
                                            <small class="text-muted">
                                                Qty: {{ $item->quantity }} &times; £{{ number_format($item->product?->price ?? 0, 2) }}
                                            </small>
                                        </div>
                                        <span class="text-dark fw-bold text-nowrap">
                                            £{{ number_format(($item->product?->price ?? 0) * $item->quantity, 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-semibold">£{{ number_format($total, 2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Standard Shipping</span>
                                <span class="text-success small fw-semibold">Free</span>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fs-5 fw-bold">Total Payable:</span>
                                <span class="fs-3 fw-bold text-success">£{{ number_format($total, 2) }}</span>
                            </div>

                            <div class="bg-light p-3 rounded mt-4 border">
                                <p class="small text-muted mb-0">
                                    <i class="bi bi-lock-fill text-success me-1"></i>
                                    By placing your order, you agree to our store terms and conditions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    @endif

@endsection