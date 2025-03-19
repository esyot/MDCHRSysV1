<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $userIds = User::role('teacher')->pluck('id');


        foreach ($userIds as $id)
        {
            Teacher::create([
                'user_id' => $id,
                'specialization' => 'Information & Technology',
            ]);
        }



    }
}
