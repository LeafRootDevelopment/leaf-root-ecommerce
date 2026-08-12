@extends('layouts.admin')

@section('title', 'Admin Dashboard - Leaf & Root')
@section('header', 'Admin Dashboard')

@section('content')
    <h2>System Overview</h2>

    <p>
        Total Products:
        <strong>{{ $productCount }}</strong>
    </p>

    <p>
        Total Categories:
        <strong>{{ $categoryCount }}</strong>
    </p>

    <h2>Quick Actions</h2>
    <ul>
        <li>
            <a href="{{ route('admin.products.create') }}">
                + Add New Product
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categories.create') }}">
                + Add New Category
            </a>
        </li>
    </ul>
@endsection