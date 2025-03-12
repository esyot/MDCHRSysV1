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
        Schema::create('terms', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('accronym', 20);
            $table->string('name');
            $table->string('type', 6);
            $table->date('enrol_start');
            $table->date('enrol_end');
            $table->date('start');
            $table->date('end');
            $table->timestamps(0);
            $table->boolean('open_enrollment')->default(0);
            $table->boolean('teacher_visible')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
