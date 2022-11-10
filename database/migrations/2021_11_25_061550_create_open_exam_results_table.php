<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenExamResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_exam_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_id');
            $table->string('name');
            $table->string('email');
            $table->string('contact')->nullable();
            $table->string('courses')->nullable();
            $table->integer('total_questions')->nullable();
            $table->integer('leaved_questions')->nullable();
            $table->integer('correct_questions')->nullable();
            $table->integer('wrong_questions')->nullable();
            $table->string('marks_obtained')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('open_exam_results');
    }
}
