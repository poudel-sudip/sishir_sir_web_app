<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQRBookScanMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_r_book_scan_members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id');
            $table->longText('book_link')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('provience', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('course')->nullable();
            $table->tinyInteger('is_main')->default(0);
            $table->tinyInteger('is_winner')->default(0);
            $table->text('winner_remarks')->nullable();
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
        Schema::dropIfExists('q_r_book_scan_members');
    }
}
