<?php

declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $completed = $this->faker->boolean();

        return [
            'user_id'      => $this->faker->numberBetween(1, 10), // Assuming you have 10 users seeded
            'title'        => $this->faker->sentence(),
            'description'  => $this->faker->paragraph(),
            'deadline'     => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'completed'    => $completed,
            'completed_at' => $completed ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'created_at'   => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at'   => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
