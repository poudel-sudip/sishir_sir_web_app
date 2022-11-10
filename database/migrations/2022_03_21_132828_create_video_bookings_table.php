<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->bigInteger('user_id');
            $table->string('user_name')->nullable();
            $table->string('status')->default('Unverified');
            $table->string('updatedBy')->nullable();
            $table->string('verificationMode')->nullable();
            $table->string('accountNo')->nullable();
            $table->string('paymentAmount')->nullable();
            $table->string('discount')->nullable()->default('0');
            $table->string('dueAmount')->nullable();
            $table->string('verificationDocument')->nullable();
            $table->string('trans_code')->nullable();
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
        Schema::dropIfExists('video_bookings');
    }
}