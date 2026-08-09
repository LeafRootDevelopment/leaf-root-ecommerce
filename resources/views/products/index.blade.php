<!DOCTYPE html>
<html>
<head>
    <title>Product Catalogue</title>
</head>
<body>

    <h1>Product Catalogue</h1>

    {{-- Reusable Alert/Flash Messages Component --}}
    <x-flash-messages />

    {{-- Search & Filter Form --}}
    <form action="{{ route('products.index') }}" method="GET">
        <div>
            {{-- Search Keyword Input --}}
            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="{{ request('search') }}"
            >

            {{-- Category Filter Dropdown --}}
            <select name="category">
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

            <button type="submit">Search</button>

            {{-- Display Clear Link if Search or Category Filter is Active --}}
            @if(request('search') || request('category'))
                <a href="{{ route('products.index') }}">Clear Filters</a>
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
            <p><strong>Price:</strong> {{ $product->formatted_price }}</p>
            <p>
                <strong>Category:</strong>
                {{ $product->category?->name ?? 'No Category' }}
            </p>

            {{-- Availability Line --}}
            <p>
                <strong>Availability:</strong>
                @if($product->isInStock())
                    <span style="color: green;">In Stock ({{ $product->stock ?? 'Available' }})</span>
                @else
                    <span style="color: red;">Out of Stock</span>
                @endif
            </p>

            {{-- Add To Basket Form or Disabled Action --}}
            @if($product->isInStock())
                <form action="{{ route('basket.add', $product) }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <div>
                        <label for="quantity-{{ $product->id }}">Quantity:</label>
                        <input
                            type="number"
                            id="quantity-{{ $product->id }}"
                            name="quantity"
                            value="1"
                            min="1"
                            max="{{ $product->max_quantity }}"
                            style="width: 60px;"
                            required
                        >
                        <button type="submit">Add To Basket</button>
                    </div>
                </form>
            @else
                <button disabled style="margin-top: 10px; opacity: 0.6; cursor: not-allowed;">
                    Out of Stock
                </button>
            @endif

            <hr>
        </div>
    @empty
        <p>No products found matching your search or filter criteria.</p>
    @endforelse
    <div style="margin-top: 20px;">
    {{ $products->links() }}
    </div>
</body>
</html>