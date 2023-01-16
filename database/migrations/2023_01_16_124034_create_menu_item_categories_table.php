<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subgroup_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('order')->nullable()->default(1);
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
        Schema::dropIfExists('menu_item_categories');
    }
}
