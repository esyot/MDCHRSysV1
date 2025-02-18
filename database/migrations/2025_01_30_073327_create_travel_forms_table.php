<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('date_start');
            $table->date('date_end');
            $table->text('description');
            $table->string('place');
            $table->string('purpose');
            $table->string('contact_person');
            $table->string('contact_person_no');
            $table->decimal('amount', 10,2);
            $table->string('budget_type');
            $table->string('budget_charged_to');
            $table->enum('semister', ['1st', '2nd', 'summer']);
            $table->enum('status', ['pending', 'dean_approved', 'hr_approved', 'vp_acad_approved','vp_admin_approved', 'declined', 'approved'])->default('pending');
            $table->date('filing_date');
            $table->bigInteger('recommended_by')->unsigned()->nullable();
            $table->bigInteger('endorsed_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_forms');
    }
};
