@extends('layouts.admin')

@section('title', 'Manage Products - Leaf & Root')
@section('header', 'Admin Products')

@section('content')
    <p>
        <a href="{{ route('admin.products.create') }}">
            + Create New Product
        </a>
    </p>

    <h2>Product Listing</h2>

    @forelse ($products as $product)
        <div>
            <h3>{{ $product->name }}</h3>

            {{-- Product Price Section --}}
            <p>
                Price:
                <strong>£{{ number_format($product->price, 2) }}</strong>
            </p>

            {{-- Product Stock Section --}}
            <p>
                Stock:
                <strong>{{ $product->stock ?? 'N/A' }}</strong>
            </p>

            <p>
                Category:
                <strong>{{ $product->category?->name ?? 'No Category' }}</strong>
            </p>

            {{-- Edit Product Link --}}
            <p>
                <a href="{{ route('admin.products.edit', $product) }}">
                    Edit Product
                </a>
            </p>

            {{-- Delete Product Form --}}
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Are you sure you want to delete {{ $product->name }}?')"
                >
                    Delete Product
                </button>
            </form>

            <hr>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
@endsection