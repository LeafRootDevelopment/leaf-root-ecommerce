@extends('layouts.admin')

@section('title', 'Edit Product - ' . $product->name)
@section('header', 'Admin Products')

@section('content')

    <div class="mb-3">
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i> Back to Product Listing
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h1 class="h4 fw-bold mb-4">Edit Product: {{ $product->name }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="price" class="form-label">Price (£)</label>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Product Image</label>

                    @if ($product->image_url)
                        <div class="mb-2">
                            <span class="small text-muted d-block mb-1">Current image:</span>
                            <img src="{{ $product->image_display_url }}" alt="{{ $product->name }}" style="width: 120px; height: 90px; object-fit: cover; border-radius: 6px;">
                        </div>
                    @endif

                    <input type="file" id="image" accept="image/*" class="form-control">
                    <div class="form-text">Leave blank to keep the current image. Select a new one to replace it.</div>

                    <div class="mt-3" id="cropContainer" style="display: none; max-width: 500px;">
                        <img id="cropPreview" style="max-width: 100%;">
                        <button type="button" id="confirmCropBtn" class="btn btn-success btn-sm mt-2">
                            <i class="bi bi-check-lg"></i> Confirm Crop
                        </button>
                        <span id="cropStatus" class="text-success small ms-2" style="display: none;">
                            <i class="bi bi-check-circle-fill"></i> Crop confirmed
                        </span>
                    </div>

                    <input type="hidden" name="cropped_image" id="croppedImageInput">
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
    let cropper = null;
    const imageInput = document.getElementById('image');
    const cropPreview = document.getElementById('cropPreview');
    const cropContainer = document.getElementById('cropContainer');
    const croppedImageInput = document.getElementById('croppedImageInput');
    const confirmCropBtn = document.getElementById('confirmCropBtn');
    const cropStatus = document.getElementById('cropStatus');

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        croppedImageInput.value = '';
        cropStatus.style.display = 'none';

        const reader = new FileReader();
        reader.onload = function (event) {
            cropPreview.src = event.target.result;
            cropContainer.style.display = 'block';

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(cropPreview, {
                aspectRatio: 4 / 3,
                viewMode: 1,
                autoCropArea: 1,
            });
        };
        reader.readAsDataURL(file);
    });

    confirmCropBtn.addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
        croppedImageInput.value = canvas.toDataURL('image/jpeg', 0.85);
        cropStatus.style.display = 'inline';
    });
</script>
@endpush
@endsection