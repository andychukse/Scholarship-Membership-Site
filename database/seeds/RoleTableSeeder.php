<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
  	{
	    $role_superadmin = new Role();
	    $role_superadmin->name = 'superadmin';
	    $role_superadmin->description = 'Super Administrator';
	    $role_superadmin->save();
	    $role_admin = new Role();
	    $role_admin->name = 'admin';
	    $role_admin->description = 'Normal Administrator';
	    $role_admin->save();
	    $role_subscriber = new Role();
	    $role_subscriber->name = 'subscriber';
	    $role_subscriber->description = 'Subscribed User';
	    $role_subscriber->save();
  	}
}
