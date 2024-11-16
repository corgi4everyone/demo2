<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
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
            'course_id' => Course::factory(),
            'title' => $this->faker->sentence,
            'url' => $this->faker->url,
        ];
    }
}
