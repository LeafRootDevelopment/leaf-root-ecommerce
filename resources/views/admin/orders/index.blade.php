@extends('layouts.admin')

@section('title', 'Manage Orders - Leaf & Root')
@section('header', 'Order Management')

@section('content')
    <div class="header-bar">
        <h2>Customer Orders</h2>

        <form action="{{ route('admin.orders.index') }}" method="GET" class="form-inline">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}" 
                placeholder="Search ID, Name, Email..." 
                class="input-text"
            >
            <button type="submit" class="btn">Search</button>
            @if(!empty($search))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>

    @if($orders->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->full_name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>£{{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="badge {{ $order->status->badgeClass() }}">
                                {{ $order->status->value }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 15px;">
            {{ $orders->links() }}
        </div>
    @else
        <p>No orders found matching your criteria.</p>
    @endif
@endsection