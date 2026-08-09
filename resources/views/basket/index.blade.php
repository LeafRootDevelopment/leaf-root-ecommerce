@extends('layouts.customer')

@section('title', 'Shopping Basket - Leaf & Root')

@section('content')

    <h1>Shopping Basket</h1>

    @if (!$basket || $basket->items->isEmpty())

        {{-- Empty Basket View --}}
        <p>Your basket is currently empty.</p>

        <p>
            <a href="{{ route('products.index') }}">
                Browse Products &rarr;
            </a>
        </p>

    @else

        {{-- Active Basket View --}}
        <p>
            <a href="{{ route('products.index') }}">
                &larr; Continue Shopping
            </a>
        </p>

        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="text-align: left;">Product</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Line Total</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($basket->items as $item)
                    <tr>
                        {{-- Product Name --}}
                        <td>
                            @if ($item->product)
                                <a href="{{ route('products.show', $item->product) }}">
                                    <strong>{{ $item->product->name }}</strong>
                                </a>
                            @else
                                <em>Product Unavailable</em>
                            @endif
                        </td>

                        {{-- Unit Price --}}
                        <td style="text-align: right;">
                            £{{ number_format($item->product->price ?? 0, 2) }}
                        </td>

                        {{-- Quantity Update Form --}}
                        <td style="text-align: center;">
                            @if ($item->product)
                                <form action="{{ route('basket.update', $item) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')

                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        value="{{ old('quantity', $item->quantity) }}" 
                                        min="1" 
                                        max="99" 
                                        style="width: 60px;" 
                                        required
                                    >

                                    <button type="submit">Update</button>

                                    {{-- Inline Validation Error Feedback --}}
                                    @error('quantity')
                                        <div style="color: red; font-size: 0.85em; margin-top: 4px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </form>
                            @else
                                <span>&mdash;</span>
                            @endif
                        </td>

                        {{-- Line Total --}}
                        <td style="text-align: right;">
                            £{{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}
                        </td>

                        {{-- Remove Item Form --}}
                        <td style="text-align: center;">
                            <form action="{{ route('basket.remove', $item) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')

                                <button 
                                    type="submit" 
                                    onclick="return confirm('Are you sure you want to remove {{ $item->product->name ?? 'this item' }} from your basket?')"
                                >
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Basket Summary & Checkout CTA --}}
        <div style="text-align: right; margin-top: 20px;">
            <h2>Basket Total: £{{ number_format($total, 2) }}</h2>

            {{-- Reserved for Sprint 2 Checkout Route --}}
            @if (Route::has('checkout.index'))
                <a href="{{ route('checkout.index') }}">
                    <button type="button" style="padding: 10px 20px; font-size: 1em;">
                        Proceed to Checkout &rarr;
                    </button>
                </a>
            @else
                <button type="button" disabled style="padding: 10px 20px; font-size: 1em;">
                    Proceed to Checkout (Coming Soon)
                </button>
            @endif
        </div>

    @endif

@endsection