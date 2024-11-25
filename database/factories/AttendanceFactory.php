<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
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
            'user_id' => \App\Models\User::where('role', 'student')->inRandomOrder()->first()->id,
            'course_id' => \App\Models\Course::factory(),
            'status' => $this->faker->randomElement(['present', 'absent']),
            'latitude' => $this->faker->numberBetween(-90, 90),
            'longitude' => $this->faker->numberBetween(-180, 180),
            'date' => $this->faker->date(),
        ];
    }
}
