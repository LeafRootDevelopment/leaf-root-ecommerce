@extends('layouts.customer')

@section('title', $product->name . ' - Product Details')

@section('content')

    {{-- Back Navigation Link --}}
    <p>
        <a href="{{ route('products.index') }}">
            &larr; Back to Product Catalogue
        </a>
    </p>

    {{-- Product Overview --}}
    <h1>{{ $product->name }}</h1>

    <p>{{ $product->description }}</p>

    <p>
        <strong>Price:</strong>
        £{{ number_format($product->price, 2) }}
    </p>

    <p>
        <strong>Category:</strong>
        {{ $product->category?->name ?? 'Uncategorised' }}
    </p>

    <hr>

    {{-- Add To Basket Form --}}
    <form action="{{ route('basket.add', $product) }}" method="POST">
        @csrf

        {{-- Quantity Selector --}}
        <p>
            <label for="quantity"><strong>Quantity:</strong></label>
            <input 
                type="number" 
                id="quantity" 
                name="quantity" 
                value="{{ old('quantity', 1) }}" 
                min="1" 
                max="99" 
                required
            >

            {{-- Inline Validation Error Display --}}
            @error('quantity')
                <span style="color: red; display: block; font-size: 0.9em; margin-top: 5px;">
                    {{ $message }}
                </span>
            @enderror
        </p>

        <button type="submit">
            Add To Basket
        </button>
    </form>

@endsection