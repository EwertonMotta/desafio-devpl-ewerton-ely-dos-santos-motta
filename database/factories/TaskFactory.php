<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10), // Assuming you have 10 users seeded
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'deadline' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'completed' => $this->faker->boolean(),
            'completed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
