<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
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
            'submission_id' => \App\Models\Submission::factory(),
            'grade' => $this->faker->randomFloat(2, 0, 100),
            'feedback' => $this->faker->paragraph,
        ];
    }
}
