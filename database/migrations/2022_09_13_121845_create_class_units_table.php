<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_units', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type')->nullable()->default('file');
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
        Schema::dropIfExists('class_units');
    }
}
