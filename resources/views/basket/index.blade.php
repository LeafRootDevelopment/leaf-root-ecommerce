@extends('layouts.customer')

@section('title', 'Shopping Basket - Leaf & Root')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1 fw-bold">Shopping Basket</h1>
            <p class="text-muted small mb-0">Review your plants and order items before proceeding</p>
        </div>
        @if ($basket && !$basket->items->isEmpty())
            <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Continue Shopping
            </a>
        @endif
    </div>

    @if (!$basket || $basket->items->isEmpty())

        {{-- Empty Basket View --}}
        <div class="card shadow-sm text-center py-5 my-4 border-0">
            <div class="card-body p-5">
                <div class="mb-3 text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-cart-x opacity-50" viewBox="0 0 16 16">
                        <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                </div>
                <h3 class="h4 card-title text-muted mb-2">Your basket is currently empty</h3>
                <p class="card-text text-secondary mb-4">Looks like you haven't added any plants or products to your basket yet.</p>
                <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="btn btn-success btn-lg px-4 fs-6">
                    Browse Products &rarr;
                </a>
            </div>
        </div>

    @else

        {{-- Active Basket View --}}
        <div class="row g-4">
            
            {{-- Items List --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Product</th>
                                    <th scope="col" class="text-end">Price</th>
                                    <th scope="col" class="text-center" style="width: 170px;">Quantity</th>
                                    <th scope="col" class="text-end">Line Total</th>
                                    <th scope="col" class="text-center pe-4" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($basket->items as $item)
                                    <tr>
                                        {{-- Product Name --}}
                                        <td class="ps-4">
                                            @if ($item->product)
                                                @if (Route::has('products.show'))
                                                    <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none fw-bold text-dark">
                                                        {{ $item->product->name }}
                                                    </a>
                                                @else
                                                    <strong class="text-dark">{{ $item->product->name }}</strong>
                                                @endif
                                            @else
                                                <em class="text-muted">Product Unavailable</em>
                                            @endif
                                        </td>

                                        {{-- Unit Price --}}
                                        <td class="text-end text-nowrap">
                                            £{{ number_format($item->product?->price ?? 0, 2) }}
                                        </td>

                                        {{-- Quantity Update Form --}}
                                        <td class="text-center">
                                            @if ($item->product)
                                                <form action="{{ Route::has('basket.update') ? route('basket.update', $item) : url('/basket/' . $item->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="input-group input-group-sm">
                                                        <input 
                                                            type="number" 
                                                            name="quantity" 
                                                            class="form-control text-center @error('quantity') is-invalid @enderror" 
                                                            value="{{ old('quantity', $item->quantity) }}" 
                                                            min="1" 
                                                            max="99" 
                                                            step="1"
                                                            required
                                                            aria-label="Quantity for {{ $item->product->name }}"
                                                            style="max-width: 65px;"
                                                        >
                                                        <button type="submit" class="btn btn-outline-secondary" title="Update Quantity">
                                                            Update
                                                        </button>
                                                    </div>

                                                    @error('quantity')
                                                        <div class="invalid-feedback d-block text-start small mt-1">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </form>
                                            @else
                                                <span class="text-muted">&mdash;</span>
                                            @endif
                                        </td>

                                        {{-- Line Total --}}
                                        <td class="text-end fw-bold text-nowrap">
                                            £{{ number_format(($item->product?->price ?? 0) * $item->quantity, 2) }}
                                        </td>

                                        {{-- Remove Item Form --}}
                                        <td class="text-center pe-4">
                                            @php
                                                $deleteRoute = Route::has('basket.destroy') 
                                                    ? route('basket.destroy', $item) 
                                                    : (Route::has('basket.remove') 
                                                        ? route('basket.remove', $item) 
                                                        : url('/basket/' . $item->id));
                                            @endphp
                                            <form action="{{ $deleteRoute }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')

                                                <button 
                                                    type="submit" 
                                                    class="btn btn-outline-danger btn-sm border-0"
                                                    title="Remove Item"
                                                    onclick="return confirm('Are you sure you want to remove {{ addslashes($item->product?->name ?? 'this item') }} from your basket?')"
                                                >
                                                    &times; Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Basket Order Summary & Checkout CTA --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 sticky-top" style="top: 20px;">
                    <h2 class="h5 fw-bold mb-3 border-bottom pb-2">Order Summary</h2>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">£{{ number_format($total, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success small fw-semibold">Calculated at checkout</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-3 fw-bold text-success">£{{ number_format($total, 2) }}</span>
                    </div>

                    {{-- Checkout Route Action --}}
                    @php
                        $checkoutRoute = Route::has('checkout.index') 
                            ? route('checkout.index') 
                            : (Route::has('checkout.create') 
                                ? route('checkout.create') 
                                : (Route::has('checkout') 
                                    ? route('checkout') 
                                    : null));
                    @endphp

                    @if ($checkoutRoute)
                        <a href="{{ $checkoutRoute }}" class="btn btn-success btn-lg w-100 py-3 fw-bold">
                            Proceed to Checkout &rarr;
                        </a>
                    @else
                        <button type="button" class="btn btn-secondary btn-lg w-100 py-3 fw-bold" disabled>
                            Proceed to Checkout (Coming Soon)
                        </button>
                    @endif

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-shield-check text-success me-1" viewBox="0 0 16 16">
                                <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.5 1.5 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.5 1.5 0 0 1 2.185 1.43C2.843 1.215 3.962.86 5.072.56z"/>
                                <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            Secure Checkout
                        </small>
                    </div>
                </div>
            </div>

        </div>

    @endif

@endsection