<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User biasa
        DB::table('users')->insert([
            'nik' => '3578012345678901',
            'name' => 'User Satu',
            'email' => 'usersatu@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_verified' => true,
        ]);

        // Admin
        DB::table('users')->insert([
            'nik' => '3578019876543210',
            'name' => 'Admin Satu',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'is_verified' => true,
        ]);
    }
}
