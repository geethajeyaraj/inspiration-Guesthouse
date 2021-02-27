<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_ref_id');
            $table->integer('booking_id');
            $table->float('amount');
            $table->integer('status')->default(0);
            $table->integer('execute_status')->default(0);
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
        Schema::dropIfExists('online_transactions');
    }
}
