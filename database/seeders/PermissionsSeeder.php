<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p = new Permission([
            'user_id' => '9f299a2c-bf6e-49f9-b93d-ebdd3b6119f2', // This was localhost Admin
            'resource_id' => 1,
            'value' => 15,
        ]);
        $p->save();
    }
}
