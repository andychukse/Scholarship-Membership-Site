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
                          <form method="POST" action="{{ secure_url('/user/role', [$user->id]) }}" id="profile" accept-charset="UTF-8" class="form-horizontal" role="form">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>First Name:</label> <span>{{ $user->firstname }}</span>  
                              </div>
                              <div class="form-group col-md-6">
                                <label>Last Name:</label> <span>{{ $user->lastname }}</span>  
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>Phone:</label> <span>{{ $user->phone }}</span>  
                              </div>
                            <div class="form-group col-md-6">
                                <label>Email:</label> <span>{{ $user->email }}</span>  
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>Role:</label> 

                                <select id="inputState" name="role" class="form-control">
                                  <option selected value="0">Not Specified</option>
                                  <option value="subscriber" @if(Session::has('errors')) @if(old('access') == 'subscriber') selected @endif @else @if(isset($role->name))@if($role->name == 'subscriber') selected @endif @endif @endif>Subscriber</option>
                                  <option value="admin" @if(Session::has('errors')) @if(old('access') == 'admin') selected @endif @else @if(isset($role->name))@if($role->name == 'admin') selected @endif @endif @endif>Admin</option>
                                  <option value="superadmin" @if(Session::has('errors')) @if(old('access') == 'superadmin') selected @endif @else @if(isset($role->name))@if($role->name == 'superadmin') selected @endif @endif @endif>Super Admin</option>
                                </select>
                                <input type="hidden" name="old_role" value="@if(isset($role->name)){{ $role->name }}@endif">
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