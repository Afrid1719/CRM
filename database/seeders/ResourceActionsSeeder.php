<?php

namespace Database\Seeders;

use App\Constants\PermissionActions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resource_actions')->insert([
            ['name' => PermissionActions::VIEW['name'], 'value' => PermissionActions::VIEW['value'], 'resource_id' => 1],
        ]); // View Permission for Dashboard only

        foreach (range(2, 6) as $resourceId) {
            DB::table('resource_actions')->insert([
                ['name' => PermissionActions::VIEW['name'], 'value' => PermissionActions::VIEW['value'], 'resource_id' => $resourceId],
                ['name' => PermissionActions::CREATE['name'], 'value' => PermissionActions::CREATE['value'], 'resource_id' => $resourceId],
                ['name' => PermissionActions::EDIT['name'], 'value' => PermissionActions::EDIT['value'], 'resource_id' => $resourceId],
                ['name' => PermissionActions::DELETE['name'], 'value' => PermissionActions::DELETE['value'], 'resource_id' => $resourceId],
            ]);
        }

        $this->command->info('Resource actions seeded successfully.');
    }
}
