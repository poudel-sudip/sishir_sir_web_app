<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('source', 100);
            $table->string('coupon');
            $table->tinyInteger('used')->default(0);
            $table->string('use_date', 100)->nullable();
            $table->bigInteger('booking_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->integer('discount')->unsigned()->nullable()->default(100);
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
        Schema::dropIfExists('booking_coupons');
    }
}
