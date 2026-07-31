<!DOCTYPE html>
<html>
<head>
    <title>Admin Categories</title>
</head>
<body>

    <h1>Admin Categories</h1>

    {{-- Create Category Link --}}
    <p>
        <a href="{{ route('admin.categories.create') }}">
            Create Category
        </a>
    </p>

    {{-- Category Loop --}}
    @foreach ($categories as $category)
        <div>
            <h2>{{ $category->name }}</h2>

            {{-- Edit Category Link --}}
            <p>
                <a href="{{ route('admin.categories.edit', $category) }}">
                    Edit Category
                </a>
            </p>

            {{-- Delete Category Form --}}
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Are you sure you want to delete {{ $category->name }}?')"
                >
                    Delete Category
                </button>
            </form>

            <hr>
        </div>
    @endforeach

</body>
</html>