<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('isPinned')->nullable()->default('No');
            $table->longText('description')->nullable();
            $table->integer('fee')->default(1);
            $table->integer('discount')->default(0);
            $table->integer('duration')->default(0);
            $table->string('durationType')->default('Days');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->string('timeSlot')->nullable();
            $table->string('classroomLink')->nullable();
            $table->string('live_link')->nullable();
            $table->string('meetingID')->nullable();
            $table->string('class_status')->default('No Class');
            $table->string('status')->default('Inactive');
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
        Schema::dropIfExists('batches');
    }
}
