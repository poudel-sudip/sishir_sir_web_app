<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('provience')->nullable();
            $table->string('district')->nullable();
            $table->string('payment_slip');
            $table->string('remarks')->nullable();
            $table->string('user_id')->nullable();
            $table->string('status')->default('Unverified');
            $table->bigInteger('team_id')->nullable();
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
        Schema::dropIfExists('manual_bookings');
    }
}
