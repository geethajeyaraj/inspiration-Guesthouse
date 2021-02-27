<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermissionsMasterTable extends Migration
{
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->unique();
	        $table->timestamps();
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->unique();
			$table->string('display_name');
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
			
			
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            
            $table->integer('can_view')->default(0)->unsigned();
            $table->integer('can_add')->default(0)->unsigned();
            $table->integer('can_update')->default(0)->unsigned();
            $table->integer('can_delete')->default(0)->unsigned();
            

            $table->primary(['permission_id', 'role_id']);
			
			
        });
    }

    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('roles');
    }
}
