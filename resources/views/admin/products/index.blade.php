<!DOCTYPE html>
<html>
<head>
    <title>Admin Products</title>
</head>
<body>

    <h1>Admin Products</h1>

    @foreach ($products as $product)
        <div>
            <h2>{{ $product->name }}</h2>

            <p>
                Category:
                {{ $product->category?->name ?? 'No Category' }}
            </p>

            {{-- 1. Corrected Edit Link --}}
            <p>
                <a href="{{ route('admin.products.edit', $product) }}">
                    Edit Product
                </a>
            </p>

            {{-- 2. Added Delete Form --}}
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $product->name }}?')">
                    Delete Product
                </button>
            </form>

            <hr>
        </div>
    @endforeach

</body>
</html>