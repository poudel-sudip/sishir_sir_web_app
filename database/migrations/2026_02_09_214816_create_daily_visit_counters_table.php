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
        Schema::create('daily_visit_counters', function (Blueprint $table) {
            $table->id();
            $table->string('visit_date');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('share_count')->default(0);
            $table->timestamps();

            $table->index('visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_visit_counters');
    }
};
