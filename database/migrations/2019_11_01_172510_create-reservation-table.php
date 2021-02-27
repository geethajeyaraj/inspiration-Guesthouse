<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateReservationTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->time('checkin_time');
            $table->time('checkout_time');
          
            $table->string('program_purpose');
            $table->string('organization')->nullable();
            $table->integer('payment_mode_id');
            $table->string('contact_person');
            $table->string('contact_person_mobileno')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->integer('training_id')->nullable();
            $table->string('course_name')->nullable();
            $table->string('additional_information')->nullable();

            $table->string('meal_needed');
            $table->integer('no_of_persons');
            $table->integer('no_of_days');
            $table->float('food_amount');
            $table->float('food_tax');
            $table->float('total_amount');
            $table->float('discount');
            $table->integer('payment_status')->default(0);
            $table->integer('status')->default(0);
            $table->string('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('reservation_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reservation_id');
            $table->integer('room_type_id');
            $table->float('room_rent');
            $table->float('extra_bed')->default(0);
            $table->float('tax_percentage');
            $table->string('room_no');
            $table->timestamps();
        });


        Schema::create('reservation_guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reservation_id');
            $table->string('email',50);
            $table->string('mobile_no');
            $table->string('title');
            $table->string('display_name');
            $table->string('gender');
            $table->string('land_line')->nullable();
            $table->string('nationality');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->integer('country');
            $table->integer('state');
            $table->integer('city');
            $table->string('pincode');
            $table->string('guest_or_trainee');
            $table->integer('id_proof');
            $table->string('id_proof_no');
            $table->string('id_proof_location');
            $table->string('formc_proof_location')->nullable();
            $table->timestamps();
        });
    }
 

    public function down()
    {
        Schema::dropIfExists('reservation_guests');
        Schema::dropIfExists('reservation_rooms');
        Schema::dropIfExists('reservations');
    }

}
