<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalAmountInReservationsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('food_no_of_days')->after('discount')->nullable();
            $table->float('total_amount')->after('food_no_of_days')->nullable();
            $table->float('total_tax_amount')->after('total_amount')->nullable();

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
            $table->dropColumn('food_no_of_days');
            $table->dropColumn('total_amount');
            $table->dropColumn('total_tax_amount');

        });
    }
}
