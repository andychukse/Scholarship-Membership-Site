@extends('layouts.app')
@section('styles')
<style>
    .blog-comments__meta a{font-size: 0.9rem; font-weight: 200;}
</style>
@endsection
@section('sidebar')
@include('layouts.nav.side')
@endsection

@section('topbar')
@include('layouts.nav.top')
@endsection 
@section('content')
<!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Dashboard</span>
                <h3 class="page-title">Overview</h3>
              </div>
            </div>
            <!-- End Page Header -->
            @if(!Auth::user()->hasAnyRole(['subscriber', 'admin', 'superadmin']))
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                @include('layouts.status')
                </div>
              <!-- Discussions Component -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="alert alert-warning rounded">
                    <h4 class="col-md-12 text-center mx-auto">Subscribe and Get Access to Scholarships, Grants / Fellowships & Visa Guidelines</h4>
                    <p class="mx-auto text-center">Subscription is <i style="text-decoration: line-through; color:#eeeeee;">&#8358;12,000</i> <strong>&#8358;5,000</strong> per year <small>Promo ends soon!</small></p>
        <div class="col-lg-4 col-md-4 mx-auto"><a href="{{ secure_url('/subscribe/standard') }}" class="btn btn-lg btn-primary d-block btn-pill mx-auto text-center">Subscribe Now</a></div>
              </div>

          </div>
      </div>
      @else
        <div class="row">
              <!-- Discussions Component -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="alert alert-primary rounded">
                    <h4 class="col-md-12 text-center mx-auto text-white p-3">Welcome to Scholarships, Grants / Fellowships & Visa Guidelines</h4>
                    <p class="mx-auto text-center">Your Subscription is Active</p>
              </div>

          </div>
      </div>
      @endif
      
            <div class="row">
             
              <!-- Discussions Component -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card card-small blog-comments">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Latest Updates</h6>
                  </div>
                  <div class="card-body p-0">
                    @foreach ($posts as $post)
                    <div class="blog-comments__item d-flex p-3">
                      <div class="blog-comments__content">
                        <div class="blog-comments__meta text-muted">
                          <a class="text-secondary" href="{{ route('view-scholar', $post->slug) }}"><strong>@if($post->funding) {{ $funding[$post->funding] }} @endif {{ $types[$post->type] }}</strong> @if($post->level) for <strong>{{ $levels[$post->level] }}</strong> study @endif @if(isset($post->name)) in <strong>{{ $post->name }}@endif</strong></a>
                          <span class="text-muted">– {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                        </div>
                      </div>
                    </div>
                    @endforeach
                   
                  </div>
                  <div class="card-footer border-top">
                    <div class="row">
                      <div class="col text-center view-report">
                        <a href="{{ secure_url('/lists') }}" class="btn btn-white">View All Posts</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Discussions Component -->
              
            </div>
           
@endsection
@section('footer')
@include('layouts.nav.footer')
@endsection
