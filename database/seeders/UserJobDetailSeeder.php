<?php

namespace Database\Seeders;

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

        foreach ($users as $user) {
            UserJobDetail::create([
                'department' => $faker->word, 
                'rank' => $faker->word,      
                'date_hired' => $faker->date('Y-m-d', '2020-01-01'), 
                'user_id' => $user->id, 
            ]);
        }
    }
}
