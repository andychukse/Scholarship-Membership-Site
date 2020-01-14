<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;

class RenewSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew expiring subscriptions';
    

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $subscriptionservice;

    public function __construct(SubscriptionService $subscriptionservice)
    {
        parent::__construct();
        $this->subscriptionservice = $subscriptionservice;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $subscriptions = Subscription::where('status', 1)
        ->where('state', 1)
        ->where('end_at', '<', Carbon::now()->addDays(1))->get();

        foreach($subscriptions as $subscription){

            $this->subscriptionservice->paymentRequest($subscription);

        }
    }

    
}
