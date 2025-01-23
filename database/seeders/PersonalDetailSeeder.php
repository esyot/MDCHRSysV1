<?php

namespace Database\Seeders;

use App\Models\PersonalDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Address;

class PersonalDetailSeeder extends Seeder
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
        $addresses = Address::all();

        foreach ($users as $user) {
            PersonalDetail::create([
                'user_id' => $user->id,
                'name_ext' => $faker->optional()->suffix, 
                'nickname' => $faker->firstName,
                'DOB' => $faker->date('Y-m-d', '2000-01-01'),
                'birthplace' => $faker->city,
                'sex' => $faker->randomElement(['male', 'female']),
                'civil_status' => $faker->randomElement(['single', 'married', 'divorced', 'widowed']),
                'religion' => $faker->word,
                'height' => $faker->randomFloat(2, 1.5, 2),
                'weight' => $faker->randomFloat(2, 40, 100),
                'blood_type' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'contact_no' => $faker->phoneNumber,
                'citizenship' => $faker->country,
                'citizenship_type' => $faker->word,
                'fb_link' => $faker->url,
                'permanent_address_id' => $addresses->random()->id,
                'residential_address_id' => $addresses->random()->id,
                'img' => $faker->imageUrl(640, 480, 'people'),
            ]);
        }
    }
}
