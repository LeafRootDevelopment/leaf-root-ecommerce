<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>

    <h1>Edit Category: {{ $category->name }}</h1>

    {{-- Back Link --}}
    <p>
        <a href="{{ route('admin.categories.index') }}">
            &larr; Back to Categories
        </a>
    </p>

    {{-- Validation Errors Block --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Category Edit Form --}}
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label for="name">Category Name:</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
            >
        </p>

        <p>
            <button type="submit">
                Update Category
            </button>

            <a href="{{ route('admin.categories.index') }}">
                Cancel
            </a>
        </p>

    </form>

</body>
</html>