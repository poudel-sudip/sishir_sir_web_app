<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('batch_id');
            $table->string('user_name')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->default('Unverified');
            $table->string('updatedBy')->nullable();
            $table->string('verificationMode')->nullable();
            $table->string('accountNo')->nullable();
            $table->string('trans_code')->nullable();
            $table->string('paymentAmount')->nullable();
            $table->string('discount')->nullable()->default('0');
            $table->string('dueAmount')->nullable();
            $table->boolean('suspended')->default(false);
            $table->string('verificationDocument')->nullable();
            $table->string('features')->nullable()->default('All');
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->rememberToken();
            $table->index(['course_id','user_id','batch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
