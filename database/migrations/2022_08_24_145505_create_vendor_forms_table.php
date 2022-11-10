<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('banner')->nullable();
            $table->string('status', 100)->nullable()->default("Active");
            $table->longText('sub_categories')->nullable();
            $table->boolean('name')->nullable()->default(true);
            $table->boolean('email')->nullable()->default(true);
            $table->boolean('contact')->nullable()->default(true);
            $table->boolean('provience')->nullable()->default(true);
            $table->boolean('photo')->nullable()->default(true);
            $table->boolean('file')->nullable()->default(true);
            $table->boolean('message')->nullable()->default(true);   
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
        Schema::dropIfExists('vendor_forms');
    }
}
