@extends('layouts.app')
@section('styles')
<style>
.post-content{font-size: 1rem;}
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
              </div>
            </div>
  <div class="my-3 p-5 bg-white rounded shadow-sm">
      <div class="blog-post">
        <h2 class="blog-post-title">{{ $post->title }}</h2>
        <p class="blog-post-meta"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($post->deadline)->format('F d, Y') }} in <a href="#">{{ $types[$post->type] }}</a> <a href="#" class="ml-2"><i class="fas fa-tag"></i> {{ $levels[$post->level] }}</a></p>
        <hr>
        <div class="post-content"> 
        {!! $post->details !!}
        @if($post->url !=='' && $post->url!==null)<a href="{{ $post->url }}" class="btn btn-lg btn-primary btn-pill">Apply Now</a>@endif
      </div>
      </div>
    </div>
      @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection