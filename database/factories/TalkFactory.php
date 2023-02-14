<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Talk>
 */
class TalkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'dir' => $this->faker->name(),
            'title' => $this->faker->title(),
            'author' => $this->faker->firstName(),
            'date' => $this->faker->date(),
            'theme' => $this->faker->firstName(),
        ];
    }
}
