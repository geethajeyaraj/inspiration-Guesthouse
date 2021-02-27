<?php

use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
	public function run()
    {

        $category[]=array('name'=>"Settings");
        $category[]=array('name'=>"Certificates");
        $category[]=array('name'=>"Blood Group");


     //   DB::table('preference_categories')->truncate();
        DB::table('preference_categories')->insert($category);

        $pre[]=array('category_id'=>1, 'key'=>"site_full_name",'value'=>"SNAM SERVICES");
        $pre[]=array('category_id'=>1, 'key'=>"site_short_name",'value'=>"SNAM");
        $pre[]=array('category_id'=>1, 'key'=>"email_id",'value'=>"selva@snamservices.com");
        $pre[]=array('category_id'=>1, 'key'=>"website",'value'=>"snamservices.com");
        $pre[]=array('category_id'=>1, 'key'=>"phone",'value'=>"9952732367");
        $pre[]=array('category_id'=>1, 'key'=>"street",'value'=>"1/237 Sevaloor");
        $pre[]=array('category_id'=>1, 'key'=>"city",'value'=>"Sivakasi");
        $pre[]=array('category_id'=>1, 'key'=>"state",'value'=>"Tamilnadu");
        $pre[]=array('category_id'=>1, 'key'=>"country",'value'=>"India");
        $pre[]=array('category_id'=>1, 'key'=>"pincode",'value'=>"626103");
        $pre[]=array('category_id'=>1, 'key'=>"dashboard_logo",'value'=>"");
        $pre[]=array('category_id'=>1, 'key'=>"login_logo",'value'=>"");
        $pre[]=array('category_id'=>1, 'key'=>"favicon",'value'=>"");

//        $pre[]=array('category_id'=>2, 'key'=>"birth_certificate",'value'=>"Birth Certificate");
//        $pre[]=array('category_id'=>2, 'key'=>"community_certificate",'value'=>"Community Certificate");
//        $pre[]=array('category_id'=>2, 'key'=>"Old Transfer Certificate",'value'=>"Old Transfer Certificate");

//        $pre[]=array('category_id'=>3, 'key'=>"A1 +ve",'value'=>"A1 +ve");
//        $pre[]=array('category_id'=>3, 'key'=>"A1 -ve",'value'=>"A1 -ve");
//        $pre[]=array('category_id'=>3, 'key'=>"B +ve",'value'=>"B +ve");


    //    DB::table('preferences')->truncate();
        DB::table('preferences')->insert($pre);



    }
}
