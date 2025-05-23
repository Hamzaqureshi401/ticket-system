<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Staff
        User::create([
            'name' => 'Staff 1',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Staff 2',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Regular users
        User::factory()->count(5)->create(['role' => 'user']);
    }
}