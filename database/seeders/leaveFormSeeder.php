<?php

namespace Database\Seeders;

use App\Models\LeaveForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class leaveFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveForm::factory()->count(100)->create();
    }
}
