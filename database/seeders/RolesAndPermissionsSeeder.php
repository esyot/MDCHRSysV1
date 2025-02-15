<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
    
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $p_admin = Role::create(['name' => 'p-admin']);
        $vp_admin = Role::create(['name' => 'vp-admin']);
        $vp_acad = Role::create(['name' => 'vp-acad']);
        $hr = Role::create(['name' => 'hr']);
        $dean = Role::create(['name' => 'dean']);       
        $staff = Role::create(['name' => 'staff']);
        
    }
}
