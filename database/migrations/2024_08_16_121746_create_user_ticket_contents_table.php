<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTicketContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ticket_contents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id');
            $table->bigInteger('user_id');
            $table->longText('message');
            $table->tinyInteger('read')->default(0);
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
        Schema::dropIfExists('user_ticket_contents');
    }
}
