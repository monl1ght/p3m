<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermassionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //     $role_admin = Role::updateorcreate(
        //         [
        //             'name' => 'admin'
        //         ],
        //         ['name' => 'admin']
        //     );

        //     $role_write = Role::updateorcreate(
        //         [
        //             'name' => 'write'
        //         ],
        //         ['name' => 'write']
        //     );

        //     $role_guest = Role::updateorcreate(
        //         [
        //             'name' => 'guest'
        //         ],
        //         ['name' => 'guest']
        //     );
        //     $permission = Permission::updateorcreate(
        //         ['name' => 'view_dashboard'],
        //         ['name' => 'view_dashboard']
        //     );
        //     $permission_dash = Permission::updateorcreate(
        //         ['name' => 'view_on_dashboard'],
        //         ['name' => 'view_on_dashboard']
        //     );

        //     $role_admin->givePermissionTo($permission);
        //     $role_admin->givePermissionTo($permission_dash);
        //     $role_write->givePermissionTo($permission_dash);

        //     $user = User::find(504);
        //     $user1 = User::find(505);
        //     $user->assignRole(['admin']);
        //     $user1->assignRole(['write']);
        // }
    }
}
