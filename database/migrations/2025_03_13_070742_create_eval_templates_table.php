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
        Schema::create('eval_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dept')->nullable();
            $table->enum('for', ['staff', 'teacher', 'others']);
            $table->boolean('is_per_subject')->default(true);
            $table->boolean('is_open')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eval_templates');
    }
};
