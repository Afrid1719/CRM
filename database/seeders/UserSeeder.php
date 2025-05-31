<?php

namespace Database\Seeders;

use App\Constants\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()->count(10)->create(); // all passwords are 'test12345'

        User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@crm.com',
                'password' => Hash::make('admin12345'),
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Admin&background=random',
                'role' => Roles::ADMIN,
            ]
        );
    }
}
