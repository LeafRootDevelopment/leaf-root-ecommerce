@extends('layouts.admin')

@section('title', 'Create Product - Leaf & Root')
@section('header', 'Admin Products')

@section('content')

    <div class="mb-3">
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i> Back to Product Listing
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h1 class="h4 fw-bold mb-4">Create Product</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="price" class="form-label">Price (£)</label>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price') }}" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" min="0" id="stock" name="stock" value="{{ old('stock') }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" id="image" name="image" accept="image/*" class="form-control">
                    <div class="form-text">Optional. JPG, PNG, or similar. Max 2MB.</div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i> Create Product
                </button>
            </form>
        </div>
    </div>

@endsection