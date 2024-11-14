<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
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
            'user_id' => User::where('role', 'student')->inRandomOrder()->first()->id,
            'course_id' => Course::factory(),
            'enrolled_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
