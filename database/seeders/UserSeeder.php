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
            'first_name' => 'Benjie',
            'last_name' => 'Lenteria',
            'middle_name' => 'Basio',
            'user' => 'lentrix',
            'email' => 'lentrix@gmail.com',
            'password' => Hash::make('ILoveMDC2025'),
        ]);

        $user1->assignRole('admin');
        $user1->assignRole('teacher');

    }
}
