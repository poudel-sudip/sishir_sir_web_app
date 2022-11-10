<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialCourseBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_course_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->bigInteger('user_id');
            $table->string('user_name')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->default('Unverified');
            $table->string('updatedBy')->nullable();
            $table->string('verificationMode')->nullable();
            $table->string('accountNo')->nullable();
            $table->string('paymentAmount')->nullable();
            $table->string('dueAmount')->nullable();
            $table->boolean('suspended')->default(false);
            $table->string('verificationDocument')->nullable();
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
        Schema::dropIfExists('special_course_bookings');
    }
}
