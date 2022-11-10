<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('vendor_discount')->nullable()->default('0');
            $table->string('isPinned')->nullable()->default('No');
            $table->string('user_access')->nullable()->default('Yes');
            $table->string('enquiry_access')->nullable()->default('No');
            $table->string('manual_booking_access')->nullable()->default('No');
            $table->string('provience')->nullable();
            $table->longText('district_city')->nullable();
            $table->string('coverage_type')->nullable()->default('provience');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
