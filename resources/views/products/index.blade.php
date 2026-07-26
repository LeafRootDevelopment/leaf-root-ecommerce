<!DOCTYPE html>
<html>
<head>
    <title>Product Catalogue</title>
</head>
<body>

<h1>Product Catalogue</h1>

@foreach ($products as $product)
    <div>
        <h2>
            {{-- Using the route() helper (assuming route name: products.show) --}}
            <a href="{{ route('products.show', $product->id) }}">
                {{ $product->name }}
            </a>
            
            {{-- Alternatively, using url(): --}}
            {{-- <a href="{{ url('/products/' . $product->id) }}">{{ $product->name }}</a> --}}
        </h2>

        <p>{{ $product->description }}</p>

        <p>Category: {{ $product->category->name }}</p>

        <hr>
    </div>
@endforeach

</body>
</html>