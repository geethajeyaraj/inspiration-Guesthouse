<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterAravindCentres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_aravind_centres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('centre_name');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('master_id_proofs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_proof_name');
            $table->integer('status');
            $table->timestamps();
        });


        Schema::create('master_training', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('training');
            $table->integer('status');
            $table->timestamps();
        });


        
        Schema::create('master_room_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_type');
            $table->integer('max_no_of_occupants');
            $table->integer('is_extra_bed_allowed');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('master_room_tariff_plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('period_master_id');
            $table->integer('room_type_id');
            $table->float('room_rent');
            $table->float('charges_extrabed');
            $table->float('tax_percentage');
            $table->date('effect_from');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('master_payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_details');
            $table->integer('status');
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
        Schema::dropIfExists('master_aravind_centres');
        Schema::dropIfExists('master_id_proofs');
        Schema::dropIfExists('master_training');
        Schema::dropIfExists('master_room_types');
        Schema::dropIfExists('master_room_tariff_plan');
        Schema::dropIfExists('master_payment_details');


    }
}
