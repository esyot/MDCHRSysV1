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
        Schema::create('leave_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('leave_type')->nullable();
            $table->string('leave_type_option')->nullable();
            $table->string('vacation_option')->nullable();
            $table->string('convalescence_place')->nullable();
            $table->string('address')->nullable();
            $table->string('sick_type')->nullable();
            $table->string('illness')->nullable();
            $table->text('reason')->nullable();
            $table->string('other_reason')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'dean_approved', 'hr_approved', 'vp_acad_approved','vp_admin_approved', 'declined', 'approved'])->default('pending');
            $table->string('endorsed_by')->nullable();
            $table->string('recommended_by')->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->date('date_of_confinement')->nullable();
            $table->date('date_of_discharge')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->integer('days_with_pay')->nullable();
            $table->integer('days_without_pay')->nullable();
            $table->integer('others')->nullable();
            $table->String('disapproval_description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_forms');
    }
};
