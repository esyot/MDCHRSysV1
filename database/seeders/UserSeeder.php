<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user1 = User::create([
            'first_name' => 'Reinhard',
            'last_name' => 'Esteban',
            'middle_name' => 'Ugay',
            'user' => 'resteban',
            'email' => 'rei.nhard3367@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user2 = User::create([
            'first_name' => 'Christoper',
            'last_name' => 'Sab',
            'middle_name' => 'Seguirel',
            'user' => 'csab',
            'email' => 'sab@gmail.com',
            'password' => Hash::make('12345678'),
        ]);


        $user1->assignRole('admin');
        $user2->assignRole('admin');
    }
}
