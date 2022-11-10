<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutor_id');
            $table->string('course');
            $table->string('fee');
            $table->string('discount')->default('0');
            $table->dateTime('startDate')->nullable();
            $table->string('payMode');
            $table->string('payAmount');
            $table->longText('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('classroomLink')->nullable();
            $table->string('timeSlot')->nullable();
            $table->string('status')->default('Inactive');
            $table->integer('worked_days')->nullable()->default(0);
            $table->integer('paid_amount')->nullable()->default(0);
            $table->string('paid_status')->nullable()->default('Unpaid');
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
        Schema::dropIfExists('special_courses');
    }
}
