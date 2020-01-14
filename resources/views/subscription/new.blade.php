@extends('layouts.app')
@section('styles')
<style>
.text-gray-dark a{font-size:1.1rem; color:#333333;}
.viewer-link a, .viewer-link span{font-size: 0.9rem; margin-right:10px; display: inline-block;}
.amount,.cards{font-size: 1.3rem;}
.cards small{font-size: 0.8rem;}
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
                <h3 class="page-title"></h3>
              </div>
            </div>
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <form method="POST" action="{{ secure_url('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-lg-12 col-md-12">
            @include('layouts.status')
            <p>
                <div class="alert alert-default">
                     <h4>Subscribe and get one year Access</h4>
                    <strong class="amount">Amount: &#8358; {{ number_format($plan->amount) }}</strong>
                </div>
            </p>
            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="orderID" value="">
            <input type="hidden" name="amount" value="{{ $plan->amount * 100 }}">
            <input type="hidden" name="callback_url" value="{{ secure_url('/payment/callback') }}">
            <input type="hidden" name="planid" value="{{ $plan->id }}">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 
            <input type="hidden" name="key" value="{{ config('paystack.publicKey') }}"> 
            @csrf

            <p>
              <button class="btn btn-success btn-lg" type="submit" value="Pay Now!">
              <i class="fas fa-credit-card fa-lg"></i> Pay Online Now!
              </button> <span class="cards"> <i class="fa fa-cc-mastercard"></i><i class="fa fa-cc-visa"></i><small> We accept MasterCard, Visa, Verve, USSD and more</small></span>
            </p>
          </div>
        </div>
</form>
  <form method="POST" action="{{ secure_url('bank') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-lg-12 col-md-12">
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 
            <input type="hidden" name="planid" value="{{ $plan->id }}">

            @csrf

            <p>
              <button class="btn btn-info btn-lg" type="submit" value="Pay Through Bank">
              <i class="fas fa-university fa-lg"></i> Pay Through Bank
              </button> <span class="cards"> <i class="fa fa-cc-mastercard"></i><i class="fa fa-cc-visa"></i><small> Click to see our bank account details</small></span>
            </p>
          </div>
        </div>
      </form>

  </div>
  @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection
@section('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
  function payWithPaystack(){
    var code = '{{ Paystack::genTranxRef() }}';
    var handler = PaystackPop.setup({
      key: '{{ config('paystack.publicKey') }}',
      email: '{{ Auth::user()->email }}',
     //plan: 'PLN_xp36kk3e0ola2yq',
     amount: {{ $plan->amount * 100 }} ,
      code: code,
      callback: function(response){
        url = "/payment/callback?trxref="+response.reference+"&reference="+code+"&uid={{ Auth::user()->id }}&planid={{ $plan->id }}";
        //console.log(response); 
        window.location.replace(url); 
      },
      onClose: function(){
          
      }
    });
  }
</script>
@endsection