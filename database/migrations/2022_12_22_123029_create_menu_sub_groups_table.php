<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSubGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_sub_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id');
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
        Schema::dropIfExists('menu_sub_groups');
    }
}
