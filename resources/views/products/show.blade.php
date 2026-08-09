@extends('layouts.customer')

@section('title', $product->name . ' - Product Details')

@section('content')

<p>
    <a href="{{ route('products.index') }}">
        &larr; Back to Product Catalogue
    </a>
</p>

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

@endsection