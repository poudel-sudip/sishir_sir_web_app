<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->bigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->string('fileTitle');
            $table->string('filePath');
            $table->rememberToken();
            $table->timestamps();
            $table->index(['batch_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_files');
    }
}
