<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReservationRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservation_rooms', function (Blueprint $table) {

            $table->renameColumn('extra_bed', 'extra_bed_amount');

            $table->integer('no_of_rooms')->default(1)->after('room_type_id');
            $table->integer('no_of_extra_beds')->nullable()->after('no_of_rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservation_rooms', function (Blueprint $table) {
            $table->dropColumn('no_of_extra_beds');

            $table->dropColumn('no_of_rooms');

            $table->renameColumn('extra_bed_amount', 'extra_bed');
        });
    }
}
