<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnwantedColumnReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('payment_mode_id');
            $table->dropColumn('meal_needed');
            $table->dropColumn('food_amount');
            $table->dropColumn('food_tax');
            $table->dropColumn('food_no_of_days');
            $table->dropColumn('food_discount');
            $table->dropColumn('total_amount');
            $table->dropColumn('total_tax_amount');
            $table->dropColumn('status');
            $table->dropColumn('comments');


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
            //
        });
    }
}
