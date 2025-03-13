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
        Schema::create('eval_template_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('eval_template_id')->unsigned();
            $table->integer('category_serial');
            $table->string('category');
            $table->timestamps();

            $table->foreign('eval_template_id')->references('id')->on('eval_templates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eval_template_categories');
    }
};
