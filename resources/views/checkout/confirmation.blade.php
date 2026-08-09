@extends('layouts.customer')

@section('title', 'Order Confirmation - Leaf & Root')

@section('content')

    <h1>Order Confirmed!</h1>

    <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        Thank you, {{ $order->first_name }}! Your order <strong>#{{ $order->id }}</strong> has been placed successfully.
    </div>

    <h2>Order Details</h2>

    <p>
        <strong>Order Reference:</strong> #{{ $order->id }}<br>
        <strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}<br>
        <strong>Email:</strong> {{ $order->email }}
    </p>

    <h3>Delivery Address</h3>
    <p>
        {{ $order->first_name }} {{ $order->last_name }}<br>
        {{ $order->address }}<br>
        {{ $order->city }}<br>
        {{ $order->postcode }}
    </p>

    <h3>Items Ordered</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="text-align: left;">Product</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Unavailable Product' }}</td>
                    <td style="text-align: right;">£{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">£{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Paid: £{{ number_format($order->total, 2) }}</h3>

    <p style="margin-top: 30px;">
        <a href="{{ route('products.index') }}">
            &larr; Continue Shopping
        </a>
    </p>

@endsection