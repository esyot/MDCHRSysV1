<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\UserJobDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserJobDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();
        
       
        $departments = Department::all();

        // Define available ranks
        $ranks = ['Teacher', 'Staff', 'Head', 'Finance'];

        foreach ($users as $user) {
            UserJobDetail::create([
                'department' => $faker->randomElement($departments)->name, // Random department from the list
                'rank' => $faker->randomElement($ranks),                  // Random rank from the list
                'date_hired' => $faker->date('Y-m-d', '2020-01-01'), 
                'user_id' => $user->id, 
            ]);
        }
    }
}
