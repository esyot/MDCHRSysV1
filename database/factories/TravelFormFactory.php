<?php

namespace Database\Factories;

use App\Models\TravelForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelFormFactory extends Factory
{
    protected $model = TravelForm::class;

    public function definition()
    {
        $userIds = User::all()->pluck('id')->toArray();
        $dateStart = $this->faker->dateTimeBetween('2024-01-01', '2026-12-31')->format('Y-m-d');
        $dateEnd = date('Y-m-d', strtotime($dateStart . ' + ' . rand(1, 10) . ' days'));
        $statuses = ['pending', 'dean_approved', 'hr_approved', 'vp_acad_approved', 'vp_admin_approved', 'declined', 'approved'];

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'description' => $this->faker->paragraph(),
            'place' => $this->faker->city(),
            'purpose' => $this->faker->sentence(),
            'contact_person' => $this->faker->name(),
            'contact_person_no' => $this->faker->phoneNumber(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'budget_type' => $this->faker->word(),
            'budget_charged_to' => $this->faker->word(),
            'semister' => $this->faker->randomElement(['1st', '2nd', 'summer']),
            'status' => $this->faker->randomElement($statuses),
            'filing_date' => $this->faker->date(),
            'recommended_by' => null,
            'endorsed_by' => null,
        ];
    }
}
