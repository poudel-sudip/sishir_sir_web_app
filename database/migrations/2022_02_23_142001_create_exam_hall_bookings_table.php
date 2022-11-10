<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamHallBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_hall_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->string('user_name');
            $table->string('status', 100)->default('Unverified');
            $table->string('updatedBy')->nullable();
            $table->string('verificationMode', 100)->nullable();
            $table->string('verificationDocument')->nullable();
            $table->string('paidAmount', 100)->nullable()->default('0');
            $table->string('discount', 100)->nullable()->default('0');
            $table->string('dueAmount', 100)->nullable()->default('0');
            $table->string('trans_code')->nullable();
            $table->mediumText('remarks')->nullable();
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
        Schema::dropIfExists('exam_hall_bookings');
    }
}
