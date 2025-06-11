<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_days', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->string('date')->nullable();
            $table->string('title')->nullable();
            $table->string('pdf_file')->nullable();
            $table->longText('description')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('sorting_date')->nullable()->default('00:00');

            $table->timestamps();

            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_days');
    }
}
