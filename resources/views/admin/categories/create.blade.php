<!DOCTYPE html>
<html>
<head>
    <title>Create Category</title>
</head>
<body>

    <h1>Create Category</h1>

    {{-- Back Link --}}
    <p>
        <a href="{{ route('admin.categories.index') }}">
            &larr; Back to Categories
        </a>
    </p>

    {{-- Category Creation Form --}}
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <p>
            <label for="name">Category Name:</label><br>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                required
            >
        </p>

        <button type="submit">
            Create Category
        </button>
    </form>

</body>
</html>