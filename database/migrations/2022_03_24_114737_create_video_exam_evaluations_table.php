<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoExamEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_exam_evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('exam_id')->nullable();
            $table->bigInteger('question_id')->nullable();
            $table->longText('question')->nullable();
            $table->longText('correct_ans')->nullable();
            $table->longText('your_ans')->nullable();
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
        Schema::dropIfExists('video_exam_evaluations');
    }
}
