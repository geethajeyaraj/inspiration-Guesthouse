<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //  DB::table('roles')->truncate();
        DB::table('roles')->insert([['name' => 'Admin'],['name' => 'Data Entry Operator'],['name' => 'Verifier']]);


		$user = array('email'=>'snamservices@gmail.com',
                'password'=> bcrypt('Snam!234'),
                'user_name'=>'snam'
                ,'display_name'=>'SNAM'
                ,'role_id'=>1
                ,'status'=>1
                ,'mobile_no'=>'9952732367'
        );
      //  DB::table('users')->truncate();
        DB::table('users')->insert($user);


     


        
		$this->call(PreferencesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
     
    }
}
