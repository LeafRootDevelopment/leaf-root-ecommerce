@extends('layouts.admin')

@section('title', 'Manage Categories - Leaf & Root')
@section('header', 'Admin Categories')

@section('content')
    <p>
        <a href="{{ route('admin.categories.create') }}">
            + Create New Category
        </a>
    </p>

    <h2>Category Listing</h2>

    @forelse ($categories as $category)
        <div>
            <h3>
                {{ $category->name }}
                @if (isset($category->products_count))
                    ({{ $category->products_count }} {{ Str::plural('product', $category->products_count) }})
                @endif
            </h3>

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
    @empty
        <p>No categories found.</p>
    @endforelse
@endsection