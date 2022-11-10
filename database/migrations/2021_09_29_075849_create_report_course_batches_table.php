<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCourseBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_course_batches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->bigInteger('batch_id');
            $table->string('name');
            $table->string('start');
            $table->string('end');
            $table->string('fee')->default(0);
            $table->string('discount')->default(0);
            $table->string('time');
            $table->string('status');
            $table->string('totalstds');
            $table->string('verifiedstds');
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
        Schema::dropIfExists('report_course_batches');
    }
}
