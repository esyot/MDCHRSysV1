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
            $table->string('reason')->nullable();
            $table->string('other_reason')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'endorsed', 'recommended','processing','declined', 'approved'])->default('pending');
            $table->string('endorsed_by')->nullable();
            $table->string('recommended_by')->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->string('medical_certificate')->nullable();
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
