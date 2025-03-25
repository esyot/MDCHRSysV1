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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->bigInteger('staff_id')->unsigned()->nullable();
            $table->bigInteger('eval_template_id')->unsigned();
            $table->bigInteger('term_id')->unsigned()->nullable();
            $table->bigInteger('acad_term_id')->unsigned()->nullable();
            $table->bigInteger('subject_id')->unsigned()->nullable();
            $table->bigInteger('evaluator_id')->unsigned()->nullable();
            $table->enum('semister', ['first', 'second']);
            $table->enum('period', ['midterm', 'final']);
            $table->string('overall_points');
            $table->string('overall_mean');
            $table->json('ratings');
            $table->json('comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
