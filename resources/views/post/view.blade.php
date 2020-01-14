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
        <p class="blog-post-meta" title="Deadline"><i class="fas fa-clock"></i> {{ $deadline = \Carbon\Carbon::parse($post->deadline)->format('F d, Y') }} in <a href="#">{{ $types[$post->type] }}</a> <a href="#" class="ml-2"><i class="fas fa-tag"></i> @if($post->level != '' && $post->level != 0){{ $levels[$post->level] }}@else Not Specified @endif</a> @if($post->funding !=0 && $post->funding!='')<span class="ml-2"><i class="fas fa-bookmark"></i> {{ $funding[$post->funding] }}</span>@endif @if(isset($country->name))<span class="ml-2"><i class="fas fa-flag"></i> {{ $country->name }}</span>@endif</p>
        <hr>
        <div class="post-content"> 
        {!! $post->details !!}

        @if($post->type == 1 || $post->type ==2 )
        @if(\Carbon\Carbon::parse($post->deadline)->lt(\Carbon\Carbon::now()))
          <div class="alert alert-warning">APPLICATION HAS CLOSED!! WATCH OUT FOR WHEN IT REOPENS</div> 
        @endif
        @endif
        @if($post->url !=='' && $post->url!==null && strtolower($post->url)!= 'null')<a href="{{ $post->url }}" class="btn btn-lg btn-primary btn-pill">Apply Now</a>@endif
        <div class="alert alert-warning mt-4"><small>Disclaimer: This is NOT the official scholarship page. This is only a one-page summarized listing of the scholarship. While we endeavor to keep the information up to date and correct, information may change at any time without notice. For complete and updated information, please always refer to the official website of the scholarship provider. Any reliance you place on information from afribary.com/scholarships is strictly at your own risk.</small></div>
      </div>
      </div>
    </div>
      @endsection
@section('footer')
@include('layouts.nav.footer')
@endsection