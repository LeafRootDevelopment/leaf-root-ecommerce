<!DOCTYPE html>
<html>
<head>
    <title>Product Catalogue</title>
</head>
<body>

    <h1>Product Catalogue</h1>

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

            <p>
                <strong>Category:</strong>
                {{ $product->category?->name ?? 'No Category' }}
            </p>

            <hr>
        </div>
    @empty
        <p>No products found matching your search or filter criteria.</p>
    @endforelse

</body>
</html>