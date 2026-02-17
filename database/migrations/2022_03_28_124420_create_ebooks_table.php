<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->string('type')->default('set');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('author')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->longText('description')->nullable();
            $table->string('isPinned')->nullable()->default('No');
            $table->longText('pdf_file')->nullable();
            $table->string('video_file')->nullable();
            $table->tinyInteger('download')->default(0);
            $table->string('pages')->nullable();
            $table->string('paper')->nullable();
            $table->integer('expiry_days')->nullable()->default(365);
            $table->string('status')->nullable()->default('Inactive');
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
        Schema::dropIfExists('ebooks');
    }
}
