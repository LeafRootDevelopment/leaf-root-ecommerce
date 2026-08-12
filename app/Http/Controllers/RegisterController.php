<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the registration form.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Store a newly registered customer.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $nameParts = explode(' ', trim($validated['name']), 2);

        $user = User::create([
            'first_name' => $nameParts[0],
            'last_name'  => $nameParts[1] ?? '',
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role'       => 'customer',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Your account has been created successfully.'
            );
    }
}