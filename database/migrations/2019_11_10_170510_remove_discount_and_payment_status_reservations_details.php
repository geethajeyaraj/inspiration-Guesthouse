<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDiscountAndPaymentStatusReservationsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('discount');
            $table->float('food_discount')->after('food_no_of_days')->default(0);
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
            
            $table->integer('payment_status')->after('total_tax_amount')->nullable();
             $table->float('discount')->after('payment_status')->nullable();
           $table->dropColumn( 'food_discount');


        });


    }
}
