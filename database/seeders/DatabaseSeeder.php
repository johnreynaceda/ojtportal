<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $course = Course::create([
            'name' => 'Bachelor of Science in Information System',
        ]);

        User::create([
            'name' => 'BSIS',
            'email' => 'coordinator1@gmail.com',
            'password' => bcrypt('password'),
            'user_type' => 'coordinator',
            'course_id' => $course->id,
            'is_approved' => true,
        ]);

        $course = Course::create([
            'name' => 'Bachelor of Science in Information Technology',
        ]);
        User::create([
            'name' => 'BSIT',
            'email' => 'coordinator2@gmail.com',
            'password' => bcrypt('password'),
            'user_type' => 'coordinator',
            'course_id' => $course->id,
            'is_approved' => true,
        ]);


        $course = Course::create([
            'name' => 'Bachelor of Science in Computer Science',
        ]);

        User::create([
            'name' => 'BSCS',
            'email' => 'coordinator3@gmail.com',
            'password' => bcrypt('password'),
            'user_type' => 'coordinator',
            'course_id' => $course->id,
            'is_approved' => true,
        ]);

        
    }
}
