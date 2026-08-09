<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set to true to allow public or logged-in checkout access.
        // You can also enforce checks like: return auth()->check();
        return true;
    }

    /**
     * Sanitize or modify input before validation rules are executed.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('postcode')) {
            $this->merge([
                'postcode' => strtoupper(trim((string) $this->postcode)),
            ]);
        }

        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower(trim((string) $this->email)),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email:rfc,dns', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:20', 'regex:/^[0-9\-\+\(\)\s]+$/'],
            'address'    => ['required', 'string', 'max:255'],
            'city'       => ['required', 'string', 'max:100'],
            'postcode'   => ['required', 'string', 'max:10', 'regex:/^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i'],
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required'  => 'Please enter your last name.',
            'email.required'      => 'A valid email address is required for order confirmation.',
            'email.email'         => 'Please provide a valid email address.',
            'address.required'    => 'Please provide a delivery address.',
            'city.required'       => 'Please specify your city or town.',
            'postcode.required'   => 'A postcode is required for delivery.',
            'postcode.regex'      => 'Please enter a valid postcode format (e.g., SW1A 1AA).',
            'phone.regex'         => 'Please enter a valid phone number format.',
        ];
    }
}