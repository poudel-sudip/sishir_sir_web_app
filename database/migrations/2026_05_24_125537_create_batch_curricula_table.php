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
        Schema::create('batch_curricula', function (Blueprint $table) {
            $table->id();
             $table->bigInteger('user_id')->nullable();
            $table->bigInteger('batch_id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('pdf_file')->nullable();
            $table->tinyInteger('is_heading')->default(0);
            $table->tinyInteger('status')->default(0);   
            $table->timestamps();
            
            $table->index('batch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_curricula');
    }
};
