<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->datetime('checkin_date')->after('reservation_id');
            $table->datetime('checkout_date')->after('checkin_date');
            $table->integer('payment_mode_id')->after('checkout_date');
            $table->integer('room_type_id')->after('payment_mode_id');
            $table->float('room_rent')->after('room_type_id')->default(0);
            $table->float('room_tax')->after('room_rent')->default(0);
            $table->float('room_discount')->after('room_tax')->default(0);

            $table->integer('room_no')->after('room_discount')->nullable();
            $table->integer('meal_needed')->after('room_no')->default(0);
            $table->float('food_amount')->after('meal_needed')->default(0);
            $table->float('food_tax')->after('food_amount')->default(0);
            $table->integer('food_no_of_days')->after('food_tax')->default(0);
            $table->float('food_discount')->after('food_no_of_days')->default(0);
            $table->float('total_amount')->after('food_discount')->default(0);
            $table->float('total_tax_amount')->after('total_amount')->default(0);
            $table->integer('status')->after('total_tax_amount')->default(0);
            $table->string('comments')->after('status')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
}
