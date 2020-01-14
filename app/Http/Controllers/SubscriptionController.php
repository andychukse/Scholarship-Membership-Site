<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Plan;
use Illuminate\Http\Request;
use Paystack;
use DB;
use App\Services\SubscriptionService;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    protected $subscriptionservice;

    public function __construct(SubscriptionService $subscriptionservice)
    {
        $this->middleware('auth');
        $this->subscriptionservice = $subscriptionservice;
    }

    public function redirectToGateway(Request $request)
    {

        $userid = $request->user()->id;

        try{
            $subscription = Subscription::create([
                'plan_id' => $request['planid'],
                'user_id' => $userid,
                'reference' => $request['reference'],
            ]);
        }

        catch(\Exception $e){
            return \Redirect::back()->with('error',$e->getMessage());
        }
            $request['orderID'] = $subscription->id;
            //$request->request->add(['plan' => $plan]); 
            return $this->subscriptionservice->redirectToGateway();


    }


    public function bank(Request $request)
    {

        $userid = $request->user()->id;

        try{
            $subscription = Subscription::create([
                'plan_id' => $request['planid'],
                'user_id' => $userid,
                'reference' => $request['reference'],
            ]);
        }

        catch(\Exception $e){
            return \Redirect::back()->with('error',$e->getMessage());
        }
            $redirectUrl = '/payment/bank/'.$subscription->id;
             return \Redirect::to($redirectUrl);


    }


    public function bankpay(Request $request, $id)
    {

        $subscription = DB::table('subscriptions')
        ->select('subscriptions.id', 'subscriptions.plan_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.end_at', 'subscriptions.reference')
        ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
        ->where(function($query) use($id, $request){
                $query->where('subscriptions.user_id', '=', $request->user()->id)
                ->where('subscriptions.id', '=', $id);})
        ->first();

        return view('subscription.bank', ["subscription" => $subscription]);
    }



    public function handleGatewayCallback()
    {

        /*$userid = $request->user()->id;

        try{
            $subscription = Subscription::create([
                'plan_id' => $request['planid'],
                'user_id' => $request['uid'],
                'reference' => $request['reference'],
            ]);
        }

        catch(\Exception $e){
            return \Redirect::back()->with('error',$e->getMessage());
        }
        */

        if($this->subscriptionservice->handleGatewayCallback()){

            \Session::flash('message', 'Subscription was successful');
            return \Redirect::to('/home');

        }

        \Session::flash('error', 'Subscription was not successful. Try Again');
            return \Redirect::to('/home');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
            if(isset($request['status'])){
                $status = $request['status'];
                $subscriptions = DB::table('subscriptions')
                ->select('subscriptions.id', 'subscriptions.plan_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.state', 'subscriptions.end_at', 'subscriptions.created_at', 'subscriptions.provider', 'subscriptions.reference', 'users.firstname', 'users.lastname')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->join('users', 'subscriptions.user_id', '=', 'users.id')
                ->where(function($query) use($status) {
                    $query->where('subscriptions.status', '=', $status);})
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            }
            elseif(isset($request['state'])){
                $state = $request['state'];
                $subscriptions = DB::table('subscriptions')
                ->select('subscriptions.id', 'subscriptions.plan_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.state', 'subscriptions.end_at', 'subscriptions.created_at', 'subscriptions.provider', 'subscriptions.reference', 'users.firstname', 'users.lastname')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->join('users', 'subscriptions.user_id', '=', 'users.id')
                ->where(function($query) use($state) {
                    $query->where('subscriptions.state', '=', $state);})
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            }
            elseif($request['q']){

            $keyword = $request['q'];

                $subscriptions = DB::table('subscriptions')
                ->select('subscriptions.id', 'subscriptions.plan_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.state', 'subscriptions.end_at', 'subscriptions.created_at', 'subscriptions.provider', 'subscriptions.reference', 'users.firstname', 'users.lastname')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->join('users', 'subscriptions.user_id', '=', 'users.id')
                ->where(function($query) use($keyword) {
                    $query->where('users.firstname', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('users.lastname', 'LIKE', '%'.$keyword.'%');})
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            }
            else{
                $subscriptions = DB::table('subscriptions')
                ->select('subscriptions.id', 'subscriptions.plan_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.state', 'subscriptions.end_at', 'subscriptions.created_at', 'subscriptions.provider', 'subscriptions.reference', 'users.firstname', 'users.lastname')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->join('users', 'subscriptions.user_id', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            }

            $total['pending'] = Subscription::where(['status' => 0])->count();
            $total['paid'] = Subscription::where(['status' => 1])->count();

        return view('subscription.index', ["subscriptions" => $subscriptions, "total" => $total]);
    }


    public function mySubscriptions(Request $request)
    {

        $subscriptions = DB::table('subscriptions')
        ->select('subscriptions.id', 'subscriptions.plan_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.state', 'subscriptions.end_at', 'subscriptions.created_at', 'subscriptions.provider', 'subscriptions.reference')
        ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
        ->where(function($query) use($request){
                $query->where('subscriptions.user_id', '=', $request->user()->id);})
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('subscription.mysubscription', compact($subscriptions, 'subscriptions'));
    }



    /**
     * Create subscription record.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, $name)
    {
        //
        if($name === 'basic'){

            \Session::flash('message', 'Sorry you cannot subscribe to this plan');
            return \Redirect::to('/home');
        }
        $plan = Plan::where('name', $name)->first();

        if($request->user()->authorizeRoles(['superadmin', 'admin','subscriber'])){

            \Session::flash('message', 'Sorry you cannot subscribe, you already have an ongoing subscription');
            return \Redirect::to('/home');
        }

        return view('subscription.new', ["plan" => $plan]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!\Auth::user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $subscription = DB::table('subscriptions')
        ->select('subscriptions.id', 'subscriptions.plan_id', 'subscriptions.user_id', 'plans.amount', 'plans.name','subscriptions.status', 'subscriptions.state', 'subscriptions.end_at', 'subscriptions.provider', 'subscriptions.created_at','subscriptions.reference')
        ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
        ->where(function($query) use ($id){
                $query->where('subscriptions.id', '=', $id);})
        ->first();

        return view('subscription.edit', ["subscription" => $subscription]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        //
        $end_at = Carbon::parse($request['end_at'])->format('Y-m-d H:i:s');
        $data = [
            'state' => $request['state'],
            'status' => $request['status'],
            'provider' => $request['provider'],
            'end_at' => $end_at,
        ];
        $oldStatus = $subscription->status;
        Subscription::where('id', $subscription->id)->update($data);

            if($request['status'] ==1 && $subscription->status == 0){

            $this->subscriptionservice->createSubscription($subscription);
            }

            if($request['status'] ==0 && $subscription->status == 1){

            $this->subscriptionservice->deleteSubscription($subscription);
            }

        



        \Session::flash('message', 'Successfully updated record!');
        $redirectUrl = '/subscription/'.$subscription->id.'/edit';

        return \Redirect::to($redirectUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
