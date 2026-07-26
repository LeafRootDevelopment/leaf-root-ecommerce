<!DOCTYPE html>
<html>
<head>
    <title>Product Catalogue</title>
</head>
<body>

    <h1>Product Catalogue</h1>

    {{-- Search Form --}}
    <form action="{{ route('products.index') }}" method="GET">
        <div>
            <input 
                type="text" 
                name="search" 
                placeholder="Search products..." 
                value="{{ request('search') }}"
            >
            <button type="submit">Search</button>

            @if(request('search'))
                <a href="{{ route('products.index') }}">Clear Search</a>
            @endif
        </div>
    </form>

    <hr>

    {{-- Product Listing --}}
    @forelse ($products as $product)
        <div>
            <h2>
                <a href="{{ route('products.show', $product) }}">
                    {{ $product->name }}
                </a>
            </h2>

            <p>{{ $product->description }}</p>
            
            {{-- Defensive Category Output --}}
            <p>
                <strong>Category:</strong> 
                {{ $product->category?->name ?? 'No Category' }}
            </p>

            <hr>
        </div>
    @empty
        <p>No products found matching your search.</p>
    @endforelse

</body>
</html>