<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQRBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_r_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->string('publisher')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('quantity')->nullable();
            $table->longText('description')->nullable();
            $table->string('author')->nullable();
            $table->string('edition')->nullable();
            $table->string('isbn')->nullable();
            $table->string('pages')->nullable();
            $table->string('availability')->nullable()->default('In Stock');
            $table->string('published_year')->nullable();
            $table->string('thumbnail')->nullable();
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
        Schema::dropIfExists('q_r_books');
    }
}
