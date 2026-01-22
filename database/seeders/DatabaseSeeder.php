<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gigabytes.com',
            'role' => 'admin',
        ]);

        // Create teacher user
        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@gigabytes.com',
            'role' => 'teacher',
        ]);

        // Create student user
        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@gigabytes.com',
            'role' => 'student',
        ]);

        // Seed badges
        $this->call(BadgeSeeder::class);
    }
}
