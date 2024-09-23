<?php

namespace Database\Factories;

use App\Models\AppUser;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(10),
            'deadline' => fake()->date('Y-m-d'),
            'assigned_user' => AppUser::query()->pluck('id')->random(),
            'assigned_client' => Client::query()->pluck('id')->random(),
            'status' => fake()->randomElement(['Open', 'In progress', 'Completed']),
        ];
    }
}
