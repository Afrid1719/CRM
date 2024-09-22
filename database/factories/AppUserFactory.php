<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppUser>
 */
class AppUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&size=100&background=random',
            'name' => $name,
            'email' => fake()->unique()->safeEmail()
        ];
    }
}
