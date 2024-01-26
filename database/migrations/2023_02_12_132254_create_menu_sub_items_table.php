<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSubItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_sub_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type', 100)->nullable()->default('file');
            $table->string('filename')->nullable();
            $table->string('fileurl')->nullable();
            $table->tinyInteger('download')->default(0);
            $table->longText('description')->nullable();
            $table->string('order')->nullable()->default(1);
            $table->string('thumbnail')->nullable();
            $table->string('author')->nullable();
            $table->longText('search_tags')->nullable();
            $table->string('status')->nullable()->default('Inactive');
            // $table->tinyInteger('notified')->nullable()->default(0);
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
        Schema::dropIfExists('menu_sub_items');
    }
}
