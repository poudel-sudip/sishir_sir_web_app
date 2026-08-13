<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_c_q_c_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('exam_id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('read')->nullable()->default(0);
            $table->timestamps();

            $table->index('exam_id');
            $table->index(['exam_id','read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_c_q_c_s');
    }
};
