<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // สร้าง Roles
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // สร้าง Permissions
        //Permission::create(['name' => 'edit articles']);
        //Permission::create(['name' => 'delete articles']);
        //Permission::create(['name' => 'publish articles']);
        //Permission::create(['name' => 'unpublish articles']);
    }
}

