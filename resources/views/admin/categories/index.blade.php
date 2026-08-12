@extends('layouts.admin')

@section('title', 'Manage Categories - Leaf & Root')
@section('header', 'Admin Categories')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Category Listing</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Create New Category
        </a>
    </div>

    <div class="row g-3">
        @forelse ($categories as $category)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                {{ $category->name }}
                                @if (isset($category->products_count))
                                    <span class="text-muted small fw-normal">
                                        ({{ $category->products_count }} {{ Str::plural('product', $category->products_count) }})
                                    </span>
                                @endif
                            </h5>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete {{ $category->name }}?')"
                                >
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No categories found.</p>
            </div>
        @endforelse
    </div>

@endsection