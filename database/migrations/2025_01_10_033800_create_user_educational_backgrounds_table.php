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
        Schema::create('user_educational_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('level', ['elem', 'sec', 'college', 'gs', 'pgs']);
            $table->string('school_name');
            $table->string('school_address');
            $table->string('course')->nullable();
            $table->date('period_attendance_from');
            $table->date('period_attendance_to');
            $table->string('units')->nullable();
            $table->year('year_graduated');
            $table->string('acad_honors_received')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_educational_backgrounds');
    }
};
