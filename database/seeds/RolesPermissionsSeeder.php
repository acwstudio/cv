<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

/**
 * Class RolesPermissionsSeeder
 */
class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_names = config('cv-default.roles');
        $perm_names = config('cv-default.permissions');
        //dd($perms);

        foreach ($role_names as $role) {
            Role::insert([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H-i-s'),
            ]);
        }

        foreach ($perm_names as $perm) {
            Permission::insert([
                'name' => $perm,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H-i-s'),
            ]);
        }

        foreach (Role::all() as $role) {

            if ($role->name == 'admin') {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());

                if  ($role->name == 'moderator' || $role->name == 'writer') {
                    $role->givePermissionTo(Permission::where('name', 'LIKE', 'view_%')->get());
                    $role->givePermissionTo(Permission::where('name', 'LIKE', '%_posts')->get());
                }
            }

        }

    }
}
