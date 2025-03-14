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
        Schema::create('eval_template_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('eval_template_category_id')->unsigned();
            $table->string('description');
            $table->timestamps();

            $table->foreign('eval_template_category_id')
                ->references('id')
                ->on('eval_template_categories')
                ->onDelete('cascade');
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eval_template_items');
    }
};
