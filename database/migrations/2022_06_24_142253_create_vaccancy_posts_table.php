<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccancyPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccancy_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('img_file')->nullable();
            $table->string('author')->nullable();
            $table->longText('description')->nullable();
            $table->text('search_tags')->nullable();
            $table->string('tag_ids')->nullable();
            $table->string('status', 100)->nullable()->default('Active');

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
        Schema::dropIfExists('vaccancy_posts');
    }
}
