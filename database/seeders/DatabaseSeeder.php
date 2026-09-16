<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin User
        |--------------------------------------------------------------------------
        |
        | This account is used to access the Admin Panel.
        | Admin registration is not available from the website.
        |
        */

        User::updateOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'name' => 'System Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Demo User
        |--------------------------------------------------------------------------
        |
        | This account is used for testing the normal User Panel.
        |
        */

        User::updateOrCreate(
            [
                'email' => 'test@example.com',
            ],
            [
                'first_name' => 'Demo',
                'last_name' => 'User',
                'name' => 'Demo User',
                'password' => Hash::make('User@12345'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}