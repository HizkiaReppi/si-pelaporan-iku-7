<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Period;
use App\Models\IKU7;
use App\Models\Department;
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

        $faculty = Faculty::factory()->create([
            'id' => Str::uuid(),
            'name' => 'Teknik',
        ]);

        $department = Department::factory()->create([
            'id' => Str::uuid(),
            'name' => 'Pendidikan Teknologi Informasi dan Komunikasi',
            'faculty_id' => $faculty->id
        ]);

        $user = User::factory()->create([
            'id' => Str::uuid(),
            'name' => 'Pendidikan Teknologi Informasi dan Komunikasi',
            'email' => 'ptik@unima.ac.id',
            'role' => 'admin-prodi',
            'password' => bcrypt('ptik'),
            'email_verified_at' => now(),
            'status' => 'approved',
            'department_id' => $department->id
        ]);

        $period = Period::factory()->create([
            'id' => 1,
            'name' => 'Ganjil 2024/2025',
            'start_date' => '2024-10-11',
            'end_date' => '2024-10-31',
        ]);

        $course = Course::factory()->create([
            'id' => 1,
            'name' => 'Pemrograman Web',
            'code' => '4263238MB',
            'department_id' => $department->id,
            'period_id' => $period->id
        ]);

        IKU7::factory()->create([
            'id' => Str::uuid(),
            'department_id' => $department->id,
            'period_id' => $period->id,
            'user_id' => $user->id,
            'course_id' => $course->id
        ]);
    }
}

