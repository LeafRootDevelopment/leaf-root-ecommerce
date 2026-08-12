@extends('layouts.customer')

@section('title', $product->name . ' - Leaf & Root')

@section('content')
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="text-success text-decoration-none">
            <i class="bi bi-arrow-left"></i> Back to Product Catalogue
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    @if ($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="width: 100%; aspect-ratio: 4/3; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center text-muted rounded" style="width: 100%; aspect-ratio: 4/3;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <h1 class="mb-2">{{ $product->name }}</h1>
                    <p class="text-muted mb-3">{{ $product->description }}</p>

                    <p class="mb-1"><strong>Category:</strong> {{ $product->category->name ?? 'Uncategorised' }}</p>
                    <p class="mb-1 fs-4 fw-bold text-success">£{{ number_format($product->price, 2) }}</p>
                    <p class="mb-3">
                        <strong>Availability:</strong>
                        @if ($product->stock > 0)
                            <span class="text-success">In Stock ({{ $product->stock }} available)</span>
                        @else
                            <span class="text-danger">Out of Stock</span>
                        @endif
                    </p>

                    @if ($product->stock > 0)
                        <form action="{{ route('basket.add', $product) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 100px;">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-bag-plus-fill me-1"></i> Add to Basket
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>Out of Stock</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection