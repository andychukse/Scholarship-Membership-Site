<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SubscriptionService;

class PaymentController extends Controller
{
    //

    protected $subscriptionservice;

    public function __construct(SubscriptionService $subscriptionservice)
    {
        $this->subscriptionservice = $subscriptionservice;
    }


    public function handleGatewayCallback()
    {
        if($this->subscriptionservice->handleGatewayCallback()){

            Log::info('Subscription was successful');
            //return \Redirect::to('/home');

        }
        Log::error('Subscription was not successful. Try Again');
        //\Session::flash('error', 'Subscription was not successful. Try Again');
            //return \Redirect::to('/home');

    }

}
