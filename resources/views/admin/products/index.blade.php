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

            <hr>
        </div>
    @endforeach

</body>
</html>