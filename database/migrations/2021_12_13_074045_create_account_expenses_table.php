<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_expenses', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('type');
            $table->string('category');
            $table->string('ledger');
            $table->bigInteger('associatedID')->nullable();
            $table->string('amount')->nullable()->default('0');
            $table->string('discount')->nullable()->default('0');
            $table->string('workedTime')->nullable();
            $table->string('fromAccount')->nullable();
            $table->string('toAccount')->nullable();
            $table->string('processedBy')->nullable();
            $table->string('verifiedBy')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('deleted')->nullable()->default(false);
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
        Schema::dropIfExists('account_expenses');
    }
}
