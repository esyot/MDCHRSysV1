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
        $dean = Role::create(['name' => 'dean']);
        $vp_acad = Role::create(['name' => 'vp-acad']);
        $staff = Role::create(['name' => 'staff']);
        $hr = Role::create(['name' => 'hr']);

       

       
    }
}
