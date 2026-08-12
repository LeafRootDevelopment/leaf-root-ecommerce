<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
public function index()
{
    $search = request('search');
    $categoryId = request('category');

    $products = Product::with('category')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->when($categoryId, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->get();

    $categories = Category::all();

    return view('products.index', compact(
        'products',
        'categories'
    ));
}

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}