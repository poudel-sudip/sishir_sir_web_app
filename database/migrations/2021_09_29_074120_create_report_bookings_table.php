<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch_id');
            $table->bigInteger('booking_id');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->string('amount');
            $table->string('mode');
            $table->string('account');
            $table->string('status');
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
        Schema::dropIfExists('report_bookings');
    }
}
