<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccancyApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccancy_applicants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vaccancy_id');
            $table->string('post_name')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->string('qualification')->nullable();
            $table->string('photo')->nullable();
            $table->string('cv')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('vaccancy_applicants');
    }
}
