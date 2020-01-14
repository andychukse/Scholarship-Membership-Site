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
                <h3 class="page-title">Profile</h3>
              </div>
            </div>
<div class="my-3 p-3 bg-white rounded shadow-sm">
    
        <div class="row" style="margin-bottom:40px;">
          <div class="col-12">@include('layouts.status')</div>
                        <div class="col-sm-12 col-md-12">
                          <strong class="text-muted d-block mb-2">My Profile</strong>
                          <form method="POST" action="{{ secure_url('/profile', [$user->id]) }}" id="profile" accept-charset="UTF-8" class="form-horizontal" role="form">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="{{ $user->firstname }}" required="">
                                @if ($errors->has('firstname'))
                                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
                                @endif
                              </div>
                              <div class="form-group col-md-6">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="{{ $user->lastname }}" required="">
                                @if ($errors->has('lastname'))
                                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
                                @endif
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="phone">Phone Number</label>
                              <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="{{ $user->phone }}" required="">
                              @if ($errors->has('phone'))
                              <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                              @endif
                            </div>
                            <div class="form-group col-md-6">
                              <label for="email">Email Address</label>
                              <input type="email" class="form-control" readonly="" name="email" id="email" placeholder="Email Address" value="{{ $user->email }}" required="">
                              @if ($errors->has('email'))
                              <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                              @endif
                            </div>
                          </div>
                            <div class="col">
                              @csrf
                              <button type="submit" form="profile" value="submit" class="mb-2 btn btn-primary mr-2">Submit</button>
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