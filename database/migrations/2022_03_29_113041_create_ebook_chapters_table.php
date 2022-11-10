<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_chapters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id');
            $table->string('name')->default('Chapter');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('pdf_file')->nullable();
            $table->string('status', 100)->nullable()->default('Active');
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
        Schema::dropIfExists('ebook_chapters');
    }
}
