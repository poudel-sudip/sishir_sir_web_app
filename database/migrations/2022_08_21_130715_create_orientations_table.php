<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrientationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orientations', function (Blueprint $table) {
            $table->id();
            $table->string('course');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('join_link')->nullable();
            $table->string('date', 100)->nullable();
            $table->string('time')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->nullable()->default("Active");
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
        Schema::dropIfExists('orientations');
    }
}
