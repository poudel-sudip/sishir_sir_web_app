<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_post_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->longText('message');
            $table->string('status')->default('Published');
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
        Schema::dropIfExists('tutor_post_comments');
    }
}
