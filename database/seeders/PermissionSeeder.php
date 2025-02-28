<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supermin_role = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        $supermin = User::firstOrCreate([
            'username' => 'admin',

        ], [
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'password',
        ]);
        $supermin->syncRoles($supermin_role);
    }
}
