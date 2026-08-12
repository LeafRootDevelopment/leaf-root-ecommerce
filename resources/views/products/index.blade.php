@extends('layouts.customer')

@section('title', 'Product Catalogue - Leaf & Root')

@section('content')
    <h1 class="mb-4">Product Catalogue</h1>

    {{-- Search & Filter Form --}}
    <form action="{{ route('products.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search products..."
                value="{{ request('search') }}"
            >
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(request('category') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-success flex-grow-1">Search</button>
            @if(request('search') || request('category'))
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </div>
    </form>

    {{-- Product Listing --}}
    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small flex-grow-1">{{ $product->description }}</p>
                        <p class="mb-1 small"><strong>Category:</strong> {{ $product->category?->name ?? 'No Category' }}</p>
                        <p class="mb-2 fw-bold text-success">£{{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-success btn-sm mt-auto">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No products found matching your search or filter criteria.</p>
            </div>
        @endforelse
    </div>
@endsection