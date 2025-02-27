<?php

namespace Database\Factories;

use App\Models\LeaveForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFormFactory extends Factory
{
    protected $model = LeaveForm::class;

    public function definition()
    {
        $userIds = User::all()->pluck('id')->toArray();
        $dateStart = $this->faker->dateTimeBetween('2024-01-01', '2026-12-31')->format('Y-m-d');
        $dateEnd = date('Y-m-d', strtotime($dateStart . ' + ' . rand(1, 10) . ' days'));
        $statuses = ['pending', 'dean_approved', 'hr_approved', 'vp_acad_approved', 'vp_admin_approved', 'declined', 'approved'];

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'leave_type' => $this->faker->word(),
            'leave_type_option' => $this->faker->word(),
            'vacation_option' => $this->faker->word(),
            'convalescence_place' => $this->faker->address(),
            'address' => $this->faker->address(),
            'sick_type' => $this->faker->word(),
            'illness' => $this->faker->word(),
            'reason' => $this->faker->sentence(),
            'other_reason' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'endorsed_by' => null,
            'recommended_by' => null,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'date_of_confinement' => $this->faker->date(),
            'date_of_discharge' => $this->faker->date(),
            'medical_certificate' => null,
            'days_with_pay' => $this->faker->numberBetween(1, 10),
            'days_without_pay' => $this->faker->numberBetween(1, 10),
            'others' => $this->faker->numberBetween(1, 10),
            'disapproval_description' => $this->faker->sentence(),
        ];
    }
}
