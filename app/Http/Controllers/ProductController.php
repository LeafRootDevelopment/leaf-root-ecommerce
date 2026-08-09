<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search and filtering.
     */
    public function index(ProductFilterRequest $request): View
    {
        // Safe access to sanitized/validated inputs
        $search = $request->validated('search');
        $categoryId = $request->validated('category');

        $products = Product::with('category')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->paginate(12)
            ->withQueryString();

        $categories = Category::select('id', 'name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}