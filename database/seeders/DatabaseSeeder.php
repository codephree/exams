<?php

namespace Database\Seeders;

use App\Models\InstructorUser;
use DB;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // DatabaseSeeder::call(General::class);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $user =  [
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]; 

        $instructor = [
            'name' => 'Default Instructor',
            'email' => 'instructor@example.com',
            'password' => bcrypt('password'),
        ];

        InstructorUser::create($instructor);
        StudentUser::create($user);
        
        DB::table('students')->insert([
            'user_id' => 1,
            'student_number' => 'S1001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
