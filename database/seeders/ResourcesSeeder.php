<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resources')->insert([
            ['name' => 'Dashboard'],
            ['name' => 'Users'],
            ['name' => 'Clients'],
            ['name' => 'Projects'],
            ['name' => 'Tasks'],
            ['name' => 'Profile']
        ]);
    }
}
