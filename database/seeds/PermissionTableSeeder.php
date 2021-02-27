<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	//	DB::table('permission_role')->truncate();
	//	DB::table('permissions')->truncate();
        DB::table('permissions')->insert([    
		
			['name' => 'manage_settings', 'display_name' => 'Manage settings'],
			['name' => 'manage_company_settings', 'display_name' => 'Manage Company settings'],
			['name' => 'edit_company_settings', 'display_name' => 'Edit Company settings'],
			
			['name' => 'manage_users', 'display_name' => 'Manage Users'],
            ['name' => 'add_user', 'display_name' => 'Add User'],
            ['name' => 'edit_user', 'display_name' => 'Edit User'],
            ['name' => 'delete_user', 'display_name' => 'Delete User'],
			
			['name' => 'manage_roles', 'display_name' => 'Manage Roles'],
            ['name' => 'add_roles', 'display_name' => 'Add Role'],
            ['name' => 'edit_roles', 'display_name' => 'Edit Role'],
            ['name' => 'delete_roles', 'display_name' => 'Delete Role'],
			
			['name' => 'manage_reports', 'display_name' => 'Manage Reports'],

		]);
    }
}
