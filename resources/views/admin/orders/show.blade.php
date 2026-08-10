@extends('layouts.admin')

@section('title', "Order #{$order->id} Details - Leaf & Root")
@section('header', "Order #{$order->id}")

@section('content')
    <p style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">&larr; Back to Orders</a>
    </p>

    <div class="grid-2" style="margin-bottom: 20px;">
        {{-- Customer Details --}}
        <div class="card">
            <h3>Customer Details</h3>
            <p><strong>First Name:</strong> {{ $order->first_name }}</p>
            <p><strong>Last Name:</strong> {{ $order->last_name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
        </div>

        {{-- Delivery Details --}}
        <div class="card">
            <h3>Delivery Details</h3>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>City:</strong> {{ $order->city }}</p>
            <p><strong>Postcode:</strong> {{ $order->postcode }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    {{-- Order Items Table --}}
    <h3>Order Items</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product Unavailable' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>£{{ number_format($item->price, 2) }}</td>
                    <td>£{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total:</td>
                <td style="font-weight: bold;">£{{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- Order Summary and Status Management --}}
    <div class="card" style="margin-top: 20px;">
        <h3>Order Status Management</h3>
        <p>Current Status: 
            <span class="badge {{ $order->status->badgeClass() }}">
                {{ $order->status->value }}
            </span>
        </p>

        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="form-inline" style="margin-top: 15px;">
            @csrf
            @method('PATCH')

            <label for="status"><strong>Update Status:</strong></label>
            <select name="status" id="status" class="input-text">
                @foreach (App\Enums\OrderStatus::cases() as $statusOption)
                    <option value="{{ $statusOption->value }}" {{ $order->status === $statusOption ? 'selected' : '' }}>
                        {{ $statusOption->value }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn">Update Status</button>
        </form>

        @error('status')
            <p style="color: red; margin-top: 8px;">{{ $message }}</p>
        @enderror
    </div>
@endsection