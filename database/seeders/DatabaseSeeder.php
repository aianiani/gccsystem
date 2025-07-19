<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'aianmark1715@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
            'registration_status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create a counselor
        $counselor = User::create([
            'name' => 'Test Counselor',
            'email' => 'yanikram11@gmail.com',
            'password' => bcrypt('counselor123'),
            'role' => 'counselor',
            'is_active' => true,
            'email_verified_at' => now(),
            'registration_status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create a student
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'naikram117@gmail.com',
            'password' => bcrypt('student123'),
            'role' => 'student',
            'is_active' => true,
            'email_verified_at' => now(),
            'registration_status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create additional test users
        User::factory(5)->create();
    }
}
