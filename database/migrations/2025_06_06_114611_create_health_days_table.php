<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_days', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->string('date')->nullable();
            $table->string('title')->nullable();
            $table->string('pdf_file')->nullable();
            $table->longText('description')->nullable();
            $table->string('author')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index('category_id');
            $table->index('date');
            $table->index(['category_id','date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_days');
    }
}
