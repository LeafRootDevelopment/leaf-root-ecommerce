<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
</head>
<body>

    <h1>Create Product</h1>

    {{-- Back Link --}}
    <p>
        <a href="{{ route('admin.products.index') }}">&larr; Back to Catalogue</a>
    </p>

    {{-- Display Global Validation Errors --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Product Creation Form --}}
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf

        {{-- Product Name --}}
        <p>
            <label for="name">Product Name:</label><br>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required
            >
        </p>

        {{-- Product Description --}}
        <p>
            <label for="description">Description:</label><br>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
            >{{ old('description') }}</textarea>
        </p>

        {{-- Category Dropdown --}}
        <p>
            <label for="category_id">Category:</label><br>
            <select id="category_id" name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option 
                        value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </p>

        {{-- Submit Button --}}
        <p>
            <button type="submit">Create Product</button>
        </p>

    </form>

</body>
</html>