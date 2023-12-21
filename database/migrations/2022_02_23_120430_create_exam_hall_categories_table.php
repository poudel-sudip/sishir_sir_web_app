<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamHallCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_hall_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('isPinned')->nullable()->default('No');
            $table->longText('description')->nullable();
            $table->string('price');
            $table->string('discount')->nullable()->default('0');
            $table->string('image')->nullable();
            $table->longText('search_tags')->nullable();
            $table->string('status', 100)->default('Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_hall_categories');
    }
}
