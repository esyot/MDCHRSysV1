<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deparment_ids = Department::all()->pluck('id');

        $users = User::all();

        foreach($users as $user){

            UserDepartment::create([
                'user_id' => $user->id,
                'department_id' =>$deparment_ids->random(),
            ]);
        }
    }
}
