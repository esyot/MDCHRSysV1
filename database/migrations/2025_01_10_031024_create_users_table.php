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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('user');
            $table->string('password');
            $table->string('email');
            $table->string('img')->nullable();
            $table->tinyInteger('is_two_step_verification')->default(false);
            $table->tinyInteger('is_update_with_email')->default(false);
            $table->tinyInteger('is_active')->default(true);
            $table->tinyInteger('is_default_pass')->default(true);
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
