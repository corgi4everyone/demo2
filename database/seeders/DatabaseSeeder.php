<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Post;
use App\Models\QuickLink;
use App\Models\Quiz;
use App\Models\Slide;
use App\Models\Submission;
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
        // Create users
        User::factory(1)->create(
            [
                'name' => 'Admin',
                'email' => 'HtY0y@example.com',
                'role' => 'admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );  // 1 admin
        User::factory(10)->create();  // 10 users (admin, teacher, student)

        // Create courses
        Course::factory(5)->create();  // 5 courses

        // Create enrollments
        Enrollment::factory(30)->create();  // 30 enrollments (3 students per course)

        // Create assignments
        Assignment::factory(10)->create();  // 10 assignments

        // Create quizzes
        Quiz::factory(5)->create();  // 5 quizzes

        // Create submissions
        Submission::factory(20)->create();  // 20 submissions

        // Create grades
        Grade::factory(20)->create();  // 20 grades

        // Create attendance
        Attendance::factory(10)->create();  // 30 attendance records

        // Create forum posts
        Post::factory(10)->create();  // 10 forum posts

        // Create forum comments
        Comment::factory(30)->create();

        // Create Course slides
        Slide::factory(10)->create();

        // Create Course quick links
        QuickLink::factory(25)->create();
    }
}
