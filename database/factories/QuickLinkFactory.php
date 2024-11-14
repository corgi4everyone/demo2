<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\QuickLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuickLink>
 */
class QuickLinkFactory extends Factory
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
            'course_id' => 1,
            'text' => $this->faker->sentence(12),
            'url' => $this->faker->url,
        ];
    }
}
