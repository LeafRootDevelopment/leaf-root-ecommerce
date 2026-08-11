@extends('layouts.customer')

@section('title', 'Product Catalogue - Leaf & Root')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1 fw-bold">Product Catalogue</h1>
            <p class="text-muted small mb-0">Explore our curated selection of indoor plants and supplies</p>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body p-3 p-md-4">
            <form action="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" method="GET">
                <div class="row g-3 align-items-center">

                    {{-- Search Keyword Input --}}
                    <div class="col-md-5">
                        <label for="search" class="visually-hidden">Search products</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                class="form-control border-start-0 ps-0"
                                placeholder="Search plants or accessories..."
                                value="{{ request('search') }}"
                            >
                        </div>
                    </div>

                    {{-- Category Filter Dropdown --}}
                    <div class="col-md-4">
                        <label for="category" class="visually-hidden">Category</label>
                        <select id="category" name="category" class="form-select">
                            <option value="">All Categories</option>
                            @if (isset($categories))
                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(request('category') == $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            Filter
                        </button>

                        @if (request()->filled('search') || request()->filled('category'))
                            <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="btn btn-outline-secondary">
                                Clear
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Product Listing --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($products as $product)
            @php
                // Safe stock calculation check
                $inStock = method_exists($product, 'isInStock') 
                    ? $product->isInStock() 
                    : (($product->stock ?? 0) > 0);
            @endphp
            
            <div class="col">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    
                    {{-- Product Image Thumbnail --}}
                    <div class="bg-light text-center py-4 rounded-top position-relative overflow-hidden" style="min-height: 180px;">
                        @if (!empty($product->image_url))
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 160px; object-fit: contain;">
                        @elseif (!empty($product->image_path))
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 160px; object-fit: contain;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted my-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-flower2 opacity-25" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm1.5-12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm1.5 4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm-3 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm5.5-3a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Stock Badge Overlay --}}
                        <div class="position-absolute top-0 end-0 m-2">
                            @if ($inStock)
                                <span class="badge bg-success bg-opacity-75">In Stock</span>
                            @else
                                <span class="badge bg-danger bg-opacity-75">Out of Stock</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column">

                        {{-- Category Tag --}}
                        <div class="mb-2">
                            <span class="badge bg-secondary-subtle text-secondary border">
                                {{ $product->category?->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <h2 class="h5 card-title fw-bold mb-2">
                            @if (Route::has('products.show'))
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            @else
                                {{ $product->name }}
                            @endif
                        </h2>

                        {{-- Description --}}
                        <p class="card-text text-muted small flex-grow-1 mb-3">
                            {{ Str::limit($product->description, 110) }}
                        </p>

                        {{-- Price --}}
                        <div class="d-flex justify-content-between align-items-center mb-3 pt-2 border-top">
                            <span class="text-muted small">Price</span>
                            <span class="fs-4 fw-bold text-success">
                                {{ $product->formatted_price ?? ('£' . number_format($product->price, 2)) }}
                            </span>
                        </div>

                        {{-- Add To Basket Form --}}
                        @if ($inStock)
                            @php
                                $formAction = Route::has('basket.add') 
                                    ? route('basket.add', $product) 
                                    : (Route::has('basket.store') 
                                        ? route('basket.store') 
                                        : url('/basket'));
                            @endphp
                            <form action="{{ $formAction }}" method="POST" class="mt-auto">
                                @csrf
                                @if (!Route::has('basket.add'))
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @endif

                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted small">Qty</span>
                                    <input
                                        type="number"
                                        id="quantity-{{ $product->id }}"
                                        name="quantity"
                                        class="form-control text-center"
                                        value="1"
                                        min="1"
                                        max="{{ $product->max_quantity ?? $product->stock ?? 99 }}"
                                        aria-label="Quantity for {{ $product->name }}"
                                        required
                                        style="max-width: 65px;"
                                    >
                                    <button type="submit" class="btn btn-success fw-semibold flex-grow-1">
                                        Add To Basket
                                    </button>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100 mt-auto" disabled>
                                Out of Stock
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <h3 class="h5 text-muted mb-2">No products found</h3>
                        <p class="text-secondary small mb-3">We couldn't find any products matching your active filters.</p>
                        <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="btn btn-outline-success btn-sm">
                            Reset Search Filters
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination Links --}}
    @if (method_exists($products, 'hasPages') && $products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif

@endsection