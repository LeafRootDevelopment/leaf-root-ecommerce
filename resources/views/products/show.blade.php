<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }} - Product Details</title>
</head>
<body>

    {{-- Back Link --}}
    <p>
        <a href="{{ route('products.index') }}">
            &larr; Back to Product Catalogue
        </a>
    </p>

    {{-- Product Details --}}
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p><strong>Category:</strong> {{ $product->category->name }}</p>

</body>
</html>