<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('publisher_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->integer('order')->nullable()->default(1);
            $table->longText('description')->nullable();
            $table->string('author')->nullable();
            $table->string('edition')->nullable();
            $table->string('isbn')->nullable();
            $table->string('pages')->nullable();
            $table->string('availability')->nullable()->default('In Stock');
            $table->text('purchase_link')->nullable();
            $table->string('published_year')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image3d')->nullable();
            $table->string('content_pdf')->nullable();
            $table->longText('search_tags')->nullable();
            $table->string('status', 100)->nullable()->default('Inactive');
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
        Schema::dropIfExists('books');
    }
}
