<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id' => Str::uuid(),
            'name' => env('SUPER_ADMIN_NAME'),
            'email' => env('SUPER_ADMIN_EMAIL'),
            'role' => 'super-admin',
            'password' => bcrypt(env('SUPER_ADMIN_PASSWORD')),
            'email_verified_at' => now(),
            'status' => 'approved',
        ]);

        User::factory()->create([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),
            'email_verified_at' => now(),
            'status' => 'approved',
        ]);
    }
}

