<!DOCTYPE html>
<html>
<head>
    <title>Edit Product - {{ $product->name }}</title>
</head>
<body>

    <h1>Edit Product: {{ $product->name }}</h1>

    {{-- Navigation / Back Link --}}
    <p>
        <a href="{{ route('admin.products.index') }}">&larr; Back to Admin Product List</a>
    </p>

    {{-- Global Validation Errors --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Product Form --}}
    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Product Name --}}
        <p>
            <label for="name">Product Name:</label><br>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', $product->name) }}" 
                required
            >
        </p>

        {{-- Description --}}
        <p>
            <label for="description">Description:</label><br>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
            >{{ old('description', $product->description) }}</textarea>
        </p>

        {{-- Category Dropdown --}}
        <p>
            <label for="category_id">Category:</label><br>
            <select id="category_id" name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option 
                        value="{{ $category->id }}"
                        @selected(old('category_id', $product->category_id) == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </p>

        {{-- Submit Button --}}
        <p>
            <button type="submit">Update Product</button>
            <a href="{{ route('admin.products.index') }}">Cancel</a>
        </p>

    </form>

</body>
</html>