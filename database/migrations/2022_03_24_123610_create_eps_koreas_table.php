<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpsKoreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eps_koreas', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mobile');
            $table->string('email');
            $table->string('sector');
            $table->string('subsector');
            $table->string('passport');
            $table->string('photo');
            $table->string('payment_slip');
            $table->string('remarks')->nullable();
            $table->string('status')->default('Unregistered');
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
        Schema::dropIfExists('eps_koreas');
    }
}
