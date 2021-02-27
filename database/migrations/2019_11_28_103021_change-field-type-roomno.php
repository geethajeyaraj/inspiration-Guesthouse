<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldTypeRoomno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_room_details', function (Blueprint $table) {
            $table->string('room_no', 50)->change();
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('room_no', 50)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_room_details', function (Blueprint $table) {
            $table->integer('room_no')->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('room_no')->change();
        });


    }
}
