<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'first_name' => 'Benjie',
            'last_name' => 'Lenteria',
            'middle_name' => 'Basio',
            'user' => 'lentrix',
            'email' => 'lentrix@gmail.com',
        ]);

        $user->assignRole('admin');
        $user->assignRole('teacher');
        $user->assignRole('hr');
        $user->assignRole('dean');

    }
}
