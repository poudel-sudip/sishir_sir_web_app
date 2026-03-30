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
        Schema::create('payment_invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('type', 100)->nullable();
            $table->bigInteger('booking_id');
            $table->string('payment_mode', 100)->nullable();
            $table->string('reference_code')->nullable();
            $table->string('payment_amount', 100)->nullable()->default(0);
            $table->string('payment_remarks')->nullable();
            $table->string('discount_amount', 100)->nullable()->default(0);
            $table->string('due_amount', 100)->nullable()->default(0);
            $table->string('verified_by')->nullable();
            $table->string('expiry_date', 100)->nullable();
            $table->tinyInteger('paid')->default(0);
            $table->tinyInteger('informed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_invoices');
    }
};
