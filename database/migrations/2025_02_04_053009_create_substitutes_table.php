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
        Schema::create('substitutes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_form_id')->unsigned();
            $table->string('subject');
            $table->bigInteger('user_id')->unsigned();
            $table->string('days');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('leave_form_id')->references('id')->on('leave_forms');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('substitutes');
    }
};
