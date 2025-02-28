<?php

namespace Database\Seeders;

use App\Models\TravelForm;
use Illuminate\Database\Seeder;

class TravelFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TravelForm::factory()->count(100)->create();
    }
}
