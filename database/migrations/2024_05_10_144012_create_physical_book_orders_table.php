<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalBookOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_book_orders', function (Blueprint $table) {
            $table->id();

            $table->string('book_category')->nullable();
            $table->string('book_title');
            $table->string('book_author')->nullable();
            $table->string('book_publisher')->nullable();
            $table->string('book_ref_image')->nullable();

            $table->string('unit_price', 100)->nullable();
            $table->string('quantity', 100)->nullable();
            $table->mediumText('message')->nullable();

            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact', 100)->nullable();
            $table->string('provience', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('location', 100)->nullable();

            $table->string('status', 50)->nullable()->default('pending');
            $table->mediumText('remarks')->nullable();

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
        Schema::dropIfExists('physical_book_orders');
    }
}
