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
        Schema::create('teacher_evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('conducted_by')->unsigned();
            $table->bigInteger('term_id')->unsigned();
            $table->string('subject');
            $table->text('questions');
            $table->text('comments');
            $table->string('ratings');
            $table->enum('period', ['Midterm', 'Final']);
            $table->timestamps();

            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('conducted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_evaluations');
    }
};
