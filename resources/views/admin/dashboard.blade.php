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

    <p>
        Total Orders:
        <strong>{{ $orderCount }}</strong>
    </p>

    <p>
        Unread Contact Messages:
        <strong>{{ $unreadContactCount }}</strong>
        @if ($unreadContactCount > 0)
            <span style="color: #d97706; font-weight: bold;">({{ $unreadContactCount }} New)</span>
        @endif
    </p>

    <h2>Quick Actions</h2>
    <ul>
        <li>
            <a href="{{ route('admin.contacts.index') }}">
                View All Contact Messages
                @if ($unreadContactCount > 0)
                    <strong>({{ $unreadContactCount }} unread)</strong>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}">
                Filter Unread Contact Messages
            </a>
        </li>
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