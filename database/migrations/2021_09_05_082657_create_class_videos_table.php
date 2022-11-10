<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->bigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->string('videoTitle');
            $table->string('videoPath');
            $table->rememberToken();
            $table->timestamps();
            $table->index(['batch_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_videos');
    }
}
