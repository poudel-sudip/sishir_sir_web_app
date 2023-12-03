<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostViewCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_view_counters', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('url');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('share_count')->default(0);
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
        Schema::dropIfExists('post_view_counters');
    }
}
