<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_countries', function (Blueprint $table) {
            $table->integer('id');
            $table->string('country_code');
            $table->string('country_name'); 
            $table->string('phone_code');
            $table->timestamps();
        });

        Schema::create('master_states', function (Blueprint $table) {
            $table->integer('id');
            $table->string('state_name');
            $table->integer('country_id');
            $table->timestamps();
        });



        Schema::create('master_cities', function (Blueprint $table) {
            $table->integer('id');
            $table->string('code');
            $table->string('city_name');
            $table->integer('state_id');
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
        Schema::dropIfExists('master_countries');
        Schema::dropIfExists('master_states');
        Schema::dropIfExists('master_cities');
    }
}
