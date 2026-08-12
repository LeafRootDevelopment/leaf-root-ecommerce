<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@leafandroot.com'],
            [
                'first_name' => 'Jordan',
                'last_name'  => 'Barker',
                'phone'      => '07123456789',
                'password'   => Hash::make('password123'),
                'role'       => 'admin',
            ]
        );

        // Standard Customer Account (used by AddressSeeder)
        User::updateOrCreate(
            ['email' => 'jane@example.com'],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Doe',
                'phone'      => '07987654321',
                'password'   => Hash::make('password123'),
                'role'       => 'customer',
            ]
        );
    }
}