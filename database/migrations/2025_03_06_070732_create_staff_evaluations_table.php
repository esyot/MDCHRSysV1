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
        Schema::create('staff_evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staff_id')->unsigned();
            $table->bigInteger('conducted_by')->unsigned();
            $table->string('average');
            $table->text('questions');
            $table->text('comments');
            $table->timestamps();


            $table->foreign('staff_id')->references('id')->on('users');
            $table->foreign('conducted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_evaluations');
    }
};
