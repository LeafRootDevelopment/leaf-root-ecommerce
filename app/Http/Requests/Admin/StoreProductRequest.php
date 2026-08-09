<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to create products.
     */
    public function authorize(): bool
    {
        // Enforce admin check or gate check
        return auth()->check() && (auth()->user()->is_admin ?? true);
    }

    /**
     * Sanitize and format inputs before running validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug'  => $this->slug ? Str::slug($this->slug) : Str::slug($this->name),
            'price' => $this->price !== null ? (float) $this->price : null,
            'stock' => $this->stock !== null ? (int) $this->stock : 0,
        ]);
    }

    /**
     * Get the validation rules for product creation.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'stock'       => ['required', 'integer', 'min:0', 'max:100000'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Max 2MB
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required'        => 'A product name is required.',
            'slug.unique'          => 'This product slug already exists. Please enter a unique name or custom slug.',
            'price.required'       => 'Please specify a product price.',
            'price.min'            => 'Price must be greater than £0.00.',
            'stock.required'       => 'Initial stock level is required.',
            'category_id.required' => 'Please assign this product to a category.',
            'category_id.exists'   => 'Selected category does not exist.',
            'image.image'          => 'The file must be a valid image format (JPG, PNG, WebP).',
            'image.max'            => 'Product image size must not exceed 2MB.',
        ];
    }
}