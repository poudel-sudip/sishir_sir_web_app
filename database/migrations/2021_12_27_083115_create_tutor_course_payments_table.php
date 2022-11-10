<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorCoursePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_course_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutor_id');
            $table->bigInteger('course_id');
            $table->string('courseType');
            $table->integer('amount');
            $table->string('status');
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('tutor_course_payments');
    }
}
