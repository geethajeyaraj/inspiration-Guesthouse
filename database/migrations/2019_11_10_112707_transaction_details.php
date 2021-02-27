<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reservation_id');
            $table->datetime('transaction_date');
            $table->integer('mode_of_payment');
            $table->integer('payment_type');
            $table->float('amount');
            $table->integer('is_collected')->nullable();
            
            $table->string('payment_ref_no')->nullable();
            $table->string('payment_ref_date')->nullable();
            $table->datetime('collection_date')->nullable();
            
            
            $table->string('description')->nullable();

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
        Schema::dropIfExists('transaction_details');
    }
}
