<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type', 100)->nullable()->default('file');
            $table->string('filename')->nullable();
            $table->string('fileurl')->nullable();
            $table->tinyInteger('download')->default(0);
            $table->longText('description')->nullable();
            $table->string('order')->nullable()->default(1);
            $table->string('thumbnail')->nullable();
            $table->longText('search_tags')->nullable();
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
        Schema::dropIfExists('library_materials');
    }
}
