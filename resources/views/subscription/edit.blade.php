@extends('layouts.app')
@section('styles')
<style>
.text-gray-dark a{font-size:1.1rem; color:#333333;}
.viewer-link a, .viewer-link span{font-size: 0.9rem; margin-right:10px; display: inline-block;}
.alert p{font-size: 1rem;}
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
    <div class="col-12">@include('layouts.status')</div>
        <div class="row" style="margin-bottom:40px;">
           
          <div class="col-lg-6 col-md-4">
            <div class="alert alert-default">
              <p>Plan: {{ $subscription->name }} </p>
              <p>Amount: {{ $subscription->amount }} </p>
              <p class="bank-details"></p>
              <p> Reference code: {{ $subscription->reference }}</p>
            </div>
          </div>

            <div class="col-lg-6 col-md-8">
              <form method="POST" action="{{ secure_url('subscription', [$subscription->id]) }}" accept-charset="UTF-8" class="form-horizontal" role="form" id="subscribe">
                <!-- Post Overview -->
                <div class='card card-small mb-3'>
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Actions</h6>
                  </div>
                  <div class='card-body p-0'>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item p-3">
                        <span class="d-flex mb-2">
                          <i class="material-icons mr-1">flag</i>
                          <strong class="mr-1">Status:</strong> 
                                  <select id="inputState" name="status" class="form-control">
                                  <option value="1" @if(Session::has('errors')) @if(old('status') == 1) selected @endif @else @if($subscription->status == 1) selected @endif @endif>Paid</option>
                                  <option value="0" @if(Session::has('errors')) @if(old('status') == 0) selected @endif @else @if($subscription->status == 0) selected @endif @endif>Pending</option>
                                </select>
                        </span>

                        <span class="d-flex mb-2">
                          <i class="material-icons mr-1">flag</i>
                          <strong class="mr-1">Provider:</strong> 
                                  <select id="inputState" name="provider" class="form-control">
                                  <option selected value="0">None</option>
                                  <option value="1" @if(Session::has('errors')) @if(old('provider') == 1) selected @endif @else @if($subscription->provider == 1) selected @endif @endif>Paystack</option>
                                  <option value="2" @if(Session::has('errors')) @if(old('provider') == 2) selected @endif @else @if($subscription->provider == 2) selected @endif @endif>Bank</option>
                                </select>
                        </span>

                        <span class="d-flex mb-2">
                          <i class="material-icons mr-1">flag</i>
                          <strong class="mr-1">Auto Renewal:</strong> 
                                  <select id="inputState" name="state" class="form-control">
                                  <option selected value="0">Not Active</option>
                                  <option value="1" @if(Session::has('errors')) @if(old('state') == 1) selected @endif @else @if($subscription->state == 1) selected @endif @endif>Active</option>
                                </select>
                        </span>
                      <div class="form-group d-flex mb-2">
                        <strong class="mr-1">End Date:</strong>
                    <div class="input-group with-addon-icon-left">
                      <input type="text" class="form-control" required="required" id="datepicker-example-1" value="@if(Session::has('errors')) {{ old('end_at') }} @else {{ \Carbon\Carbon::parse($subscription->end_at)->format('m/d/Y') }} @endif" name="end_at" placeholder="End Date">
                      <span class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                    @if ($errors->has('end_at'))
                      <div class="invalid-feedback">{{ $errors->first('end_at') }}</div>
                      @endif
                  </div>
                      </li>
                      <li class="list-group-item d-flex px-3">
                        @csrf
                        <button class="btn btn-sm btn-accent ml-auto" type="submit" form="subscribe" value="submit">
                          <i class="material-icons">file_copy</i> Update</button>
                      </li>
                    </ul>
                  </div>
                </div>
              </form>
              </div>
        </div>


  </div>
  @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection
@section('scripts')
<script src="{{ secure_asset('js/shards.min.js') }}"></script>
  <script src="{{ secure_asset('js/demo.min.js') }}"></script>
  @endsection