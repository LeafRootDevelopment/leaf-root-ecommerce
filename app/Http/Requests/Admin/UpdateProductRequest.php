<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to update products.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->is_admin ?? true);
    }

    /**
     * Sanitize inputs prior to validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name') && !$this->has('slug')) {
            $this->merge(['slug' => Str::slug($this->name)]);
        } elseif ($this->has('slug')) {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }

        if ($this->has('price')) {
            $this->merge(['price' => (float) $this->price]);
        }

        if ($this->has('stock')) {
            $this->merge(['stock' => (int) $this->stock]);
        }
    }

    /**
     * Get the validation rules for updating an existing product.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Retrieve the product route parameter dynamically
        $product = $this->route('product');
        $productId = is_object($product) ? $product->id : $product;

        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'stock'       => ['required', 'integer', 'min:0', 'max:100000'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required'        => 'A product name is required.',
            'slug.unique'          => 'This URL slug is already taken by another product.',
            'price.required'       => 'Please specify a product price.',
            'price.min'            => 'Price must be greater than £0.00.',
            'category_id.required' => 'Please select a product category.',
        ];
    }
}