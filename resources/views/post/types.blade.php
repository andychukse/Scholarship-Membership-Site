@extends('layouts.app')
@section('styles')
<style>

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
                <h3 class="page-title">{{ $types[$type] }}</h3>
              </div>
            </div>
<div class="row">
  @foreach ($posts as $post)
              <div class="col-lg-4">
                <div class="card card-small card-post mb-4">
                  <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('view-scholar', $post->slug) }}">{{ $post->title }}</a></h5>
                    <p class="card-text text-muted"> {!! Str::words(strip_tags($post->details),20) !!}...</p>
                  </div>
                  <div class="card-footer border-top d-flex">
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('/scholarships/images/avatars/@if($post->type === 1)scholar.png @elseif($post->type === 2)grant.png @elseif($post->type === 3)guide.png @endif');">{{ $types[$post->type] }}</a>
                      <div class="d-flex flex-column justify-content-center ml-3">
                        <span class="card-post__author-name">{{ $types[$post->type] }}</span>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($post->deadline)->format('F d, Y') }}</small>
                      </div>
                    </div>
                    <div class="my-auto ml-auto">
                      <a class="btn btn-sm btn-white" href="#">
                        <i class="fas fa-tag mr-1"></i> {{ $levels[$post->level] }} </a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              
              {{ $posts->links() }}
            </div>

            @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection