<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCheckinDateandtime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('checkin_time');
            $table->dropColumn('checkout_time');

            $table->datetime('checkin_date')->change();
            $table->datetime('checkout_date')->change();
       
       
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
            $table->date('checkin_date')->change();
            $table->date('checkout_date')->change();
       
            $table->time('checkin_time');
            $table->time('checkout_time');


        });
    }
}
