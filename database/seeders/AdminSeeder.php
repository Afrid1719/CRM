<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Constants\Roles;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@crm.com',
                'password' => Hash::make('admin12345'),
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Admin&background=random',
                'role' => Roles::ADMIN,
            ]
        );

        $resources = DB::table('resources')->select('id')->get();

        foreach ($resources as $resource) {
            if ($resource->id == 1) {
                $permission = new Permission([
                    'user_id' => $admin->id,
                    'resource_id' => $resource->id,
                    'value' => 1, // View permission for Dashboard only
                ]);
            } else {
                $permission = new Permission([
                    'user_id' => $admin->id,
                    'resource_id' => $resource->id,
                    'value' => 15, // Full permissions (view, create, edit, delete)
                ]);
            }
            $permission->save();
        }
        $this->command->info('Admin user created with full permissions.');
    }
}
