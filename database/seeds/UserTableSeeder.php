<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
  	{
	    $role_superadmin = Role::where('name', 'superadmin')->first();
	    $role_admin  = Role::where('name', 'admin')->first();
	    $role_subscriber  = Role::where('name', 'subscriber')->first();
	    $superadmin = new User();
	    $superadmin->firstname = 'Andy';
	    $superadmin->lastname = 'Kings';
	    $superadmin->email = 'andy@afribary.com';
	    $superadmin->password = bcrypt('chuks3040');
	    $superadmin->save();
	    $superadmin->roles()->attach($role_superadmin);

	    $subscriber = new User();
	    $subscriber->firstname = 'Paul';
	    $subscriber->lastname = 'Eze';
	    $subscriber->email = 'paul@afribary.com';
	    $subscriber->password = bcrypt('drcongo60');
	    $subscriber->save();
	    $subscriber->roles()->attach($role_admin);
  	}
}
