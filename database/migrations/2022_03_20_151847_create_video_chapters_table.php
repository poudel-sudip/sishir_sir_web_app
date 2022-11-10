<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_chapters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->integer('sn')->unsigned()->nullable()->default(12);
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('status')->nullable()->default('Inactive');
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
        Schema::dropIfExists('video_chapters');
    }
}
