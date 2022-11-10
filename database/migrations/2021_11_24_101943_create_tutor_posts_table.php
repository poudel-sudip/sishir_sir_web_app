<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutor_id');
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('status')->default('Unpublished');
            $table->bigInteger('views')->nullable()->default(0);
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
        Schema::dropIfExists('tutor_posts');
    }
}
