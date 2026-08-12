<?php

namespace App\Http\Requests;

use App\Models\Basket;
use App\Models\BasketItem;
use Illuminate\Foundation\Http\FormRequest;

class AddToBasketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        // Determine available stock constraint safely
        if ($product && isset($product->stock)) {
            $maxAllowed = max(0, min((int) $product->stock, 99));
        } else {
            $maxAllowed = 99;
        }

        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $maxAllowed],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'quantity.required' => 'Please enter a quantity.',
            'quantity.integer'  => 'Quantity must be a valid whole number.',
            'quantity.min'      => 'You must add at least 1 item to your basket.',
            'quantity.max'      => 'The requested quantity exceeds available stock.',
        ];
    }

    /**
     * Additional validation after basic rules pass.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $product = $this->route('product');

            if (!$product) {
                return;
            }

            // Reject attempt to add out-of-stock product
            if (isset($product->stock) && $product->stock <= 0) {
                $validator->errors()->add(
                    'quantity',
                    "Sorry, {$product->name} is currently out of stock."
                );
                return;
            }

            // Verify accumulated basket quantity against available stock
            if (isset($product->stock)) {
                $basket = Basket::where('session_id', session()->getId())->first();

                if ($basket) {
                    $existingItem = BasketItem::where('basket_id', $basket->id)
                        ->where('product_id', $product->id)
                        ->first();

                    $existingQty = $existingItem ? $existingItem->quantity : 0;
                    $requestedQty = (int) $this->input('quantity', 1);

                    if (($existingQty + $requestedQty) > $product->stock) {
                        $remaining = max(0, $product->stock - $existingQty);
                        $validator->errors()->add(
                            'quantity',
                            "You already have {$existingQty} in your basket. Only {$remaining} more can be added."
                        );
                    }
                }
            }
        });
    }
}