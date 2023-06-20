<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('rate_of_interest')->nullable();
            $table->string('no_of_emi')->nullable();
            $table->string('emi_amount')->nullable();
            $table->string('emi_date')->nullable();
            $table->string('interest_to_paid')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('received_amount')->nullable();
            $table->string('pending_amount')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
