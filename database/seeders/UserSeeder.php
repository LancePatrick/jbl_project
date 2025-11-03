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
        User::create([
            'name' => 'name test',
            'email' => 'test@admin.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
