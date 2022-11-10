<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_tutors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutor_id');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->string('qualification');
            $table->string('experience');
            $table->longText('courses')->nullable();         
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
        Schema::dropIfExists('report_tutors');
    }
}
