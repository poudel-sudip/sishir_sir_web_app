<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyMCQQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_m_c_q_questions', function (Blueprint $table) {
            $table->id();
            $table->longText('question');
            $table->longText('opt_a')->nullable();
            $table->longText('opt_b')->nullable();
            $table->longText('opt_c')->nullable();
            $table->longText('opt_d')->nullable();
            $table->string('opt_correct')->nullable();
            $table->longText('rationale')->nullable();
            $table->string('show_date')->nullable();
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
        Schema::dropIfExists('daily_m_c_q_questions');
    }
}
