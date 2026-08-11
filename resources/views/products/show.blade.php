@extends('layouts.customer')

@section('title', $product->name . ' - Product Details')

@section('content')

    {{-- Breadcrumb Navigation --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="text-decoration-none">
                    &larr; Back to Product Catalogue
                </a>
            </li>
            <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 250px;">
                {{ $product->name }}
            </li>
        </ol>
    </nav>

    {{-- Product Details Container --}}
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body p-4 p-lg-5">
            <div class="row g-4 align-items-center">

                {{-- Product Image / Visual Container --}}
                <div class="col-lg-6 text-center">
                    <div class="bg-light rounded p-4 d-flex align-items-center justify-content-center" style="min-height: 320px;">
                        @if (!empty($product->image_url))
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 350px; object-fit: contain;">
                        @elseif (!empty($product->image_path))
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 350px; object-fit: contain;">
                        @else
                            <div class="text-muted py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-flower2 opacity-25 mb-2" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm1.5-12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm1.5 4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm-3 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm5.5-3a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                </svg>
                                <p class="small mb-0">No image available for this item</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Overview & Add to Basket --}}
                <div class="col-lg-6">
                    
                    {{-- Category Tag & Stock Status --}}
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-secondary-subtle text-secondary border">
                            {{ $product->category?->name ?? 'Uncategorised' }}
                        </span>

                        @if (method_exists($product, 'isInStock'))
                            @if ($product->isInStock())
                                <span class="badge bg-success bg-opacity-75">In Stock</span>
                            @else
                                <span class="badge bg-danger bg-opacity-75">Out of Stock</span>
                            @endif
                        @endif
                    </div>

                    {{-- Product Name --}}
                    <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>

                    {{-- Price Display --}}
                    <div class="mb-4">
                        <span class="fs-2 fw-bold text-success">
                            {{ $product->formatted_price ?? ('£' . number_format($product->price, 2)) }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <h2 class="h6 text-muted text-uppercase fw-semibold mb-2">Description</h2>
                        <p class="text-secondary leading-relaxed mb-0">
                            {{ $product->description }}
                        </p>
                    </div>

                    <hr class="my-4">

                    {{-- Basket Form --}}
                    @php
                        $inStock = method_exists($product, 'isInStock') ? $product->isInStock() : true;
                        $formAction = Route::has('basket.add') 
                            ? route('basket.add', $product) 
                            : (Route::has('basket.store') 
                                ? route('basket.store') 
                                : url('/basket'));
                    @endphp

                    @if ($inStock)
                        <form action="{{ $formAction }}" method="POST">
                            @csrf
                            @if (!Route::has('basket.add'))
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @endif

                            <div class="row g-3 align-items-center">
                                <div class="col-sm-5 col-md-4">
                                    <label for="quantity" class="form-label fw-bold mb-1">Quantity</label>
                                    <input 
                                        type="number" 
                                        id="quantity" 
                                        name="quantity" 
                                        class="form-control form-control-lg text-center @error('quantity') is-invalid @enderror" 
                                        value="{{ old('quantity', 1) }}" 
                                        min="1" 
                                        max="{{ $product->max_quantity ?? $product->stock ?? 99 }}" 
                                        required
                                        aria-label="Quantity for {{ $product->name }}"
                                    >
                                </div>

                                <div class="col-sm-7 col-md-8 pt-sm-4">
                                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                        Add To Basket
                                    </button>
                                </div>
                            </div>

                            {{-- Inline Validation Error Display --}}
                            @error('quantity')
                                <div class="invalid-feedback d-block mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </form>
                    @else
                        <button type="button" class="btn btn-secondary btn-lg w-100 fw-bold" disabled>
                            Out of Stock
                        </button>
                    @endif

                </div>

            </div>
        </div>
    </div>

@endsection