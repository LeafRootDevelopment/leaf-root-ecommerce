@extends('layouts.admin')

@section('title', 'Admin Dashboard - Leaf & Root')
@section('header', 'Admin Dashboard')

@section('content')

    <h1 class="h3 fw-bold mb-4">System Overview</h1>

    <div class="row g-3 mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam text-success fs-2"></i>
                    <h2 class="fw-bold mt-2 mb-0">{{ $productCount }}</h2>
                    <p class="text-muted small mb-0">Products</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-tags text-success fs-2"></i>
                    <h2 class="fw-bold mt-2 mb-0">{{ $categoryCount }}</h2>
                    <p class="text-muted small mb-0">Categories</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-receipt text-success fs-2"></i>
                    <h2 class="fw-bold mt-2 mb-0">{{ $orderCount }}</h2>
                    <p class="text-muted small mb-0">Orders</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-envelope text-success fs-2"></i>
                    <h2 class="fw-bold mt-2 mb-0">{{ $contactCount }}</h2>
                    <p class="text-muted small mb-0">Contact Messages</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="h5 fw-bold mb-3">Quick Actions</h2>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add New Product
        </a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success">
            <i class="bi bi-plus-lg me-1"></i> Add New Category
        </a>
    </div>

@endsection