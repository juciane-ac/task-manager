<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::findByName('admin');
        $permissions = Permission::all();
        $adminRole->givePermissionTo($permissions);


        $managerRole = Role::findByName('manager');
        $permissions = Permission::whereIn('name', ['view_tasks', 'edit_tasks','create_tasks','update_tasks','delete_tasks','view_projects','create_projects','edit_projects','update_projects','delete_projects'])->get();
        $managerRole->givePermissionTo($permissions);

        $userRole = Role::findByName('user');
        $permissions = Permission::whereIn('name', ['view_tasks','edit_tasks','update_tasks'])->get();
        $userRole->givePermissionTo($permissions);
    }
}

