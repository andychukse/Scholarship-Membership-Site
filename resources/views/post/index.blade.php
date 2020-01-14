@extends('layouts.app')
@section('styles')
<style>
.text-gray-dark a{font-size:1.1rem; color:#333333;}
.viewer-link a, .viewer-link span{font-size: 0.9rem; margin-right:10px; display: inline-block;}
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
                <h3 class="page-title">Scholarship Posts</h3>
              </div>
            </div>
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">List of Posts</h6>
    @foreach ($posts as $post)
    <div class="media text-muted pt-3">
      <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <h5 class="d-block text-gray-dark"><a href="{{ route('post.edit', $post->id) }}">{{ $post->title }}</a></h5>
        <div class="viewer-link"><a href="{{ route('post.show', $post->id) }}"><i class="fas fa-eye"></i> View</a>  <a href="{{ route('view-scholar', $post->slug) }}"><i class="fas fa-eye"></i>Public View</a> <a href="{{ route('post.edit', $post->id) }}"><i class="fas fa-edit"></i> Edit</a>  <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($post->deadline)->format('F d, Y') }}</span></div>
      </div>
    </div>
    @endforeach
    
      {{ $posts->links() }}
  </div>
  @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection