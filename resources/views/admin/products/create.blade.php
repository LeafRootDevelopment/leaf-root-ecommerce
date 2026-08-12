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
                    <input type="file" id="image" accept="image/*" class="form-control">
                    <div class="form-text">Optional. Select an image, then drag to choose the crop area (matches catalogue display).</div>

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
                    <i class="bi bi-check-lg me-1"></i> Create Product
                </button>
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
        console.log('Crop confirmed, data length:', croppedImageInput.value.length);
    });
</script>
@endpush
@endsection