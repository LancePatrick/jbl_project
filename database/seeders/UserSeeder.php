<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'admin test',
            'email' => 'test@admin.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'created_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'name' => 'user test',
            'email' => 'test@user.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'created_at' => now(),
        ]);
  // Create teller
        User::create([
            'name' => 'uses teller',
            'email' => 'test@teller.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'created_at' => now(),
        ]);
    }
}
