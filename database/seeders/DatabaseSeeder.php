<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(AddressSeeder::class);

        $this->call(PersonalDetailSeeder::class);
        
        $this->call(UserJobDetailSeeder::class);



    }
}
