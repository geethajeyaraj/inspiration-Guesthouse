<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentPayable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_payment_details', function (Blueprint $table) {
            $table->integer('is_rent_payable')->default(1)->after('payment_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_payment_details', function (Blueprint $table) {
            $table->dropColumn('is_rent_payable');
        });
    }
}
