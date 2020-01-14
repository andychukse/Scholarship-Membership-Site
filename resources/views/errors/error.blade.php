@extends('layouts.app')
@section('sidebar')
@include('layouts.nav.side')
@endsection

@section('topbar')
@include('layouts.nav.top')
@endsection 
@section('content')
            
            <!-- Default Light Table -->
            <div class="error">
            <div class="error__content">
              <h2>Oops!</h2>
              <h3>Something went wrong!</h3>
              <p>There was a problem on our end. Please try again later.</p>
              <a href="{{ secure_url('/home') }}" class="btn btn-accent btn-pill">&larr; Go Back</a>
            </div>
            <!-- / .error_content -->
          </div>
            <!-- End Default Light Table -->
@endsection
@section('footer')
@include('layouts.nav.footer')
@endsection 