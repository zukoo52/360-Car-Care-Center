<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ApplicationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'user_create']);
        Permission::firstOrCreate(['name' => 'user_view']);
        Permission::firstOrCreate(['name' => 'user_update']);
        Permission::firstOrCreate(['name' => 'user_delete']);

        Permission::firstOrCreate(['name' => 'role_create']);
        Permission::firstOrCreate(['name' => 'role_view']);
        Permission::firstOrCreate(['name' => 'role_update']);
        Permission::firstOrCreate(['name' => 'role_delete']);

        Permission::firstOrCreate(['name' => 'branch_create']);
        Permission::firstOrCreate(['name' => 'branch_view']);
        Permission::firstOrCreate(['name' => 'branch_update']);
        Permission::firstOrCreate(['name' => 'branch_delete']);

        // Single Permissions
        Permission::firstOrCreate(['name' => 'other_systemNotifications']);

    }
}
