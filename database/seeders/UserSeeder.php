<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin Super - bisa akses semuanya
        User::create([
            'name' => 'Super Admin Caldera',
            'email' => 'admin@caldera.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Staff Manager - bisa mengelola operasional
        User::create([
            'name' => 'Manager Caldera',
            'email' => 'manager@caldera.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '081234567891',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Staff Kitchen - hanya untuk dapur
        User::create([
            'name' => 'Chef Caldera',
            'email' => 'chef@caldera.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '081234567892',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Staff Pool - hanya untuk kolam
        User::create([
            'name' => 'Pool Attendant',
            'email' => 'pool@caldera.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '081234567893',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Customer biasa - untuk testing
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@customer.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '081234567894',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@customer.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '081234567895',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@customer.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '081234567896',
            'avatar' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}