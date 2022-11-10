<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->integer('order')->default(1);
            $table->longText('description')->nullable();
            $table->longText('detail')->nullable();
            $table->string('isPopular')->default('No');
            $table->string('image')->nullable();
            $table->string('status')->default('Inactive');
            $table->timestamps();
            $table->rememberToken();

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
        Schema::dropIfExists('courses');
    }
}
