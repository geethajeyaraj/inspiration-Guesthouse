<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name',50)->unique();
            $table->string('email',50)->unique();
            $table->string('mobile_no')->unique();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            
            $table->string('title')->nullable();
            $table->string('display_name');
            $table->string('gender')->nullable();
            $table->string('land_line')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->integer('country')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->string('pincode')->nullable();
            
            $table->string('guest_type')->default(0);
            $table->string('staff_type')->default(0);
            
            $table->integer('center_id')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            
            $table->integer('id_proof')->nullable();
            $table->string('id_proof_no')->nullable();
            $table->string('id_proof_location')->nullable();
       

            $table->string('image_location')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('otp_no')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->rememberToken();
            $table->integer('last_modified_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
