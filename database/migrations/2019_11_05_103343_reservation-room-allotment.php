<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReservationRoomAllotment extends Migration
{
    public function up()
    {
        Schema::create('reservation_room_allotments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reservation_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('reservation_room_allotment');
    }
}
