<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReservationRemoveNos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            
            $table->dropColumn('no_of_persons');
            $table->dropColumn('no_of_days');
            $table->dropColumn('total_amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('no_of_persons');
            $table->integer('no_of_days');
            $table->float('total_amount');

        });


    }
}
