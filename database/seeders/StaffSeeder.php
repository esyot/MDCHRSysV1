<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new Faker instance
        $faker = Faker::create();

        $userIds = User::role('staff')->pluck('id');

        foreach ($userIds as $id)
        {
            Staff::create([
                'user_id' => $id,
                'position' => 'Wa ra',
                'date_hired' => $faker->date(),
            ]);
        }
    }
}
