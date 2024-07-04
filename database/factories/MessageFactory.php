<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
            'attachment' => $this->faker->word,
            'is_read' => $this->faker->boolean,
            'read_at' => $this->faker->dateTime,
            'sent_at' => $this->faker->dateTime,
            'received_at' => $this->faker->dateTime
        ];
    }
}
