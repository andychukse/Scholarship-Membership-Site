<?php

use Illuminate\Database\Seeder;
use App\Plan;
class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
       /* $plan = new Plan();
	    $plan->name = 'basic';
	    $plan->amount = 2000;
	    $plan->duration = 365;
	    $plan->save();*/

        $plan = new Plan();
        $plan->name = 'standard';
        $plan->amount = 5000;
        $plan->duration = 365;
        $plan->save();
    }
}
