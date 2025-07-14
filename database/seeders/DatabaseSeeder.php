<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            $this->call([
                ResourcesSeeder::class,
                ResourceActionsSeeder::class,
                AdminSeeder::class,
                UserSeeder::class,
                ClientSeeder::class,
                ProjectSeeder::class,
                TaskSeeder::class,
            ]);
        } catch (\Exception $e) {
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }
    }
}
