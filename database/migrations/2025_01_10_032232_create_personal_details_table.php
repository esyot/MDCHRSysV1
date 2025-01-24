<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name_ext')->nullable();
            $table->string('nickname')->nullable();
            $table->date('DOB')->nullable();
            $table->string('birthplace')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->enum('civil_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->string('religion')->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->string('contact_no')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('citizenship_type')->nullable();

            $table->string('fb_link');
            $table->bigInteger('permanent_address_id')->unsigned();
            $table->bigInteger('residential_address_id')->unsigned();
            $table->string('img');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permanent_address_id')->references('id')->on('addresses');
            $table->foreign('residential_address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_details');
    }
};
