<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use App\User;
use App\Plan;
use App\Role;
use App\Subscription;
use Paystack;
use Carbon\Carbon;
use App\Notifications\SubscriptionSucess;

class SubscriptionService
{

	/**
     * Issue Secret Key from your Paystack Dashboard
     * @var string
     */
    protected $secretKey;

    /**
     * Instance of Client
     * @var Client
     */
    protected $client;

    /**
     *  Response from requests made to Paystack
     * @var mixed
     */
    protected $response;

    /**
     * Paystack API base Url
     * @var string
     */
    protected $baseUrl;

    public function __construct(){

    	$this->setKey();
        $this->setBaseUrl();
        $this->setRequestHeaders();
    }

    public function setBaseUrl()
    {
    	//dd(Config::get('paystack.paymentUrl'));
        $this->baseUrl = Config::get('paystack.paymentUrl');
        //$this->baseUrl = 'https://api.paystack.co';
    }

    /**
     * Get secret key from Paystack config file
     */
    public function setKey()
    {
        $this->secretKey = Config::get('paystack.secretKey');
    }

    /**
     * Set options for making the Client request
     */
    private function setRequestHeaders()
    {
        $authBearer = 'Bearer '. $this->secretKey;

        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'Authorization' => $authBearer,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ]
            ]
        );
    }
    public function paymentRequest($subscription)
    {
        $user = User::where('id', $subscription->user_id)->first();
        $plan = Plan::where('id', $subscription->plan_id)->first();
        $refcode = Paystack::genTranxRef();

        $sub = Subscription::create([
            'plan_id' => $subscription->plan_id,
            'user_id' => $subscription->user_id,
            'reference' => $refcode,
        ]);

        $data = [
            "amount" => $plan->amount,
            "reference" => $refcode,
            "email" => $user->email,
            "authorization_code" => $subscription->auth_code,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "callback_url" => 'https://afribary.com/scholarships/renew/callback', 
        ];

        //$request->request->add($data); 

        // Remove the fields which were not sent (value would be null)
        array_filter($data);

        $this->setHttpResponse('/transaction/charge_authorization', 'POST', $data);

        return $this;
    }


     /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        
        return Paystack::getAuthorizationUrl()->redirectNow();
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $response = Paystack::getPaymentData();
        //dd($paymentDetails);
        if(isset($response['status']) && isset($response['message']) && isset($response['data']['status'])){
	        if($response['data']['status']=='success' && $response['status'] == true){
	        
	        	$authorization_code = $response['data']['authorization']['authorization_code'];
	        	//$paymentDate = Carbon::parse($response['data']['transaction_date'])->format('Y-m-d H:i:s');
	        	$end_at = Carbon::now()->addYears(1);
	        	//TO DO add duration from duration column in plans table Carbon::now()->addDays($plan->duration);
	        	$reference = $response['data']['reference'];

	        	$data = [
	            'end_at' => $end_at,
	            'provider' => 1,
	            'auth_code' => $authorization_code,
	            'status' => 1,
	            'state' => 1,
            	];
            	$subscription = Subscription::where('reference', $reference)->first();
            	Subscription::where('id',$subscription->id)->update($data);
            	//dd($subscription);
            	return $this->createSubscription($subscription);

            	//return true;
            	
            	}
            }

            return false;
    }

    public function createSubscription($subscription){

    		$user = User::where('id', $subscription->user_id)->first();
            //dd($user);
            $user->roles()->attach(Role::where('name', 'subscriber')->first());

            $user->notify(new SubscriptionSucess($subscription));

            return $user;
            //$user->roles()->detach(Role::where('name', 'subscriber')->first());

    }


    public function deleteSubscription($subscription){

    		$user = User::where('id', $subscription->user_id)->first();
            
            $user->roles()->detach(Role::where('name', 'subscriber')->first());

            return $user;

    }

    private function setHttpResponse($relativeUrl, $method, $body = [])
    {

        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl . $relativeUrl,
            ["body" => json_encode($body)]
        );

        return $this;
    }

}