@extends('layouts.app')
@section('styles')
<style>
.text-gray-dark a{font-size:1.1rem; color:#333333;}
.viewer-link a, .viewer-link span{font-size: 0.9rem; margin-right:10px; display: inline-block;}
.bank-details span {font-size:1.3rem;}
.amount{font-size: 1.3rem;}
.alert p{ font-size: 1rem; }
.alert .ref{color:#06c;}
</style>
@endsection

@section('sidebar')
@include('layouts.nav.side')
@endsection

@section('topbar')
@include('layouts.nav.top')
@endsection 

@section('content')
<div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Dashboard</span>
                <h3 class="page-title">Subscription Bank Payment</h3>
              </div>
            </div>
<div class="my-3 p-3 bg-white rounded shadow-sm">
    
        <div class="row" style="margin-bottom:40px;">
           
            <div class="col-lg-12">
            <div class="alert alert-default">
              <p>Pay <strong class="amount">&#8358;{{ $subscription->amount }}</strong> to our of the account below</p>
              <p class="bank-details"><span class="account-name">Account Name</span> - <span class="account">0000000000</span> - <span class="bank">Bank Name</span></p>
              <p> After payment, email your <strong class="ref">Name</strong> to bankpay@email.com</p>
            </div>
          </div>
        </div>


  </div>
  @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection