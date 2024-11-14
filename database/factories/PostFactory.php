<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => User::where('role', 'teacher')->inRandomOrder()->first()->id,
            'course_id' => 1,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
}
