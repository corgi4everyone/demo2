<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Submission>
 */
class SubmissionFactory extends Factory
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
            'assignment_id' => \App\Models\Assignment::factory(),
            //'quiz_id' => \App\Models\Quiz::factory(),
        ];
    }
}
