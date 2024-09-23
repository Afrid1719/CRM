<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::query()->get(['id', 'assigned_user', 'assigned_client'])->random();
        return [
            'title' => ucwords(fake()->words(3, true)),
            'description' => ucfirst(fake()->sentence(20)),
            'status' => fake()->boolean(70),
            'assigned_to' => $project->assigned_user,
            'related_to_project' => $project->id,
            'for_client' => $project->assigned_client,
            'deleted_at' => fake()->boolean(30) ? Carbon::now() : null
        ];
    }
}
