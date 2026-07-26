<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
{
    $search = request('search');

    $products = Product::with('category')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->get();

    return view('products.index', compact('products'));
}

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}