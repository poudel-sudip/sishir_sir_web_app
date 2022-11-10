<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorFormApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_form_applicants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->nullable();
            $table->bigInteger('form_id');
            $table->string('sub_category')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('provience')->nullable();
            $table->string('district')->nullable();
            $table->string('photo')->nullable();
            $table->string('file')->nullable();
            $table->longText('message')->nullable();
            $table->longText('remarks')->nullable();
            $table->longText('uploaded_by')->nullable();
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
        Schema::dropIfExists('vendor_form_applicants');
    }
}
