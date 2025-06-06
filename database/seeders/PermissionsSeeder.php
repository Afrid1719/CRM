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
            'user_id' => '9d12b37a-52b6-49e8-bfba-54df960a6a96',
            'resource_id' => 1,
            'value' => 5,
        ]);
        $p->save();
    }
}
