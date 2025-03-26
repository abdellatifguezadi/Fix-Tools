<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user if doesn't exist
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create 5 professional users
        User::factory()->count(5)->create([
            'role' => 'professional',
        ]);

        // Create 5 regular users
        User::factory()->count(5)->create([
            'role' => 'user',
        ]);
    }
} 