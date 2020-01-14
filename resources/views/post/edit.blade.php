@extends('layouts.app')
@section('styles')
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.snow.css"> -->
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
                <span class="text-uppercase page-subtitle">Scholarship Posts</span>
                <h3 class="page-title">Edit Post</h3>
              </div>
            </div>
            <form class="add-new-post" method="post" action="{{ secure_url('post', [$post->id]) }}" enctype="multipart/form-data" id="post">
            <!-- End Page Header -->
            <div class="row">
              
              <div class="col-lg-9 col-md-12">
                <!-- Add New Post Form -->
                @include('layouts.status')
                <div class="card card-small mb-3">
                  <div class="card-body">
                      <input class="form-control form-control-lg mb-3" required value="{{ $post->title }}" name="title" type="text" placeholder="Your Post Title">
                      @if ($errors->has('title'))
                      <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                      @endif
                      {{ method_field('PATCH') }}
                      @csrf
                      <textarea id="details" name="details" placeholder="Enter post details...">@if(Session::has('errors')) {{ old('details') }} @else {{ $post->details }} @endif</textarea>
                      @if ($errors->has('details'))
                      <div class="invalid-feedback">{{ $errors->first('details') }}</div>
                      @endif
                      <!--<input name="slug" value="{{ $post->slug }}" type="hidden">-->
                      <!--<div id="editor-container" class="add-new-post__editor mb-1"></div> -->
                  </div>
                </div>
                <!-- / Add New Post Form -->
              </div>
              <div class="col-lg-3 col-md-12">
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
                          <strong class="mr-1">Funding:</strong> 
                                  <select id="inputState" name="funding" class="form-control">
                                  <option selected value="0">Not Specified</option>
                                  <option value="1" @if(Session::has('errors')) @if(old('funding') == 1) selected @endif @else @if($post->funding == 1) selected @endif @endif>Fully Funded</option>
                                  <option value="2" @if(Session::has('errors')) @if(old('funding') == 2) selected @endif @else @if($post->funding == 2) selected @endif @endif>Partially Funded</option>
                                </select>
                        </span>
                        <span class="d-flex mb-2">
                          <i class="material-icons mr-1">flag</i>
                          <strong class="mr-1">Country:</strong> 
                                  <select id="inputState" name="country_id" class="form-control">
                                    <option selected value="0">Country</option>
                                    @foreach($countries as $country)
                                  <option value="{{ $country->id }}" @if(Session::has('errors')) @if(old('country_id') == $country->id) selected @endif @else @if($post->country_id == $country->id) selected @endif @endif>{{ $country->name }}</option>
                                  @endforeach
                                </select>
                        </span>

                            <div class="form-group d-flex mb-2">
                        <div class="input-group">
                          <span class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-link"></i>
                            </span>
                          </span>
                          <input type="text" class="form-control" value="@if(Session::has('errors')) {{ old('url') }} @else {{ $post->url }} @endif" name="url" id="form-url" placeholder="Url">
                          @if ($errors->has('url'))
                          <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                      @endif
                        </div>
                      </div>

                      <div class="form-group d-flex mb-2">
                    <div class="input-group with-addon-icon-left">
                      <input type="text" class="form-control" id="datepicker-example-1" value="@if(Session::has('errors')) {{ old('deadline') }} @else {{ \Carbon\Carbon::parse($post->deadline)->format('m/d/Y') }} @endif" name="deadline" placeholder="Deadline">
                      <span class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                    @if ($errors->has('deadline'))
                      <div class="invalid-feedback">{{ $errors->first('deadline') }}</div>
                      @endif
                  </div>
                      </li>
                      <li class="list-group-item d-flex px-3">
                        <button class="btn btn-sm btn-accent ml-auto" type="submit" form="post" value="submit">
                          <i class="material-icons">file_copy</i> Upload</button>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- / Post Overview -->
                <!-- Post Overview -->
                <div class='card card-small mb-3'>
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Post Type</h6>
                  </div>
                  <div class='card-body p-0'>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item px-3 pb-2">
                        <div class="custom-control custom-radio mb-1">
                          <input type="radio" class="custom-control-input" name="type" id="category1" @if(Session::has('errors')) @if(old('type') == 1) checked @endif @else @if($post->type == 1) checked @endif @endif value="1">
                          <label class="custom-control-label" for="category1">Scholarship</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                          <input type="radio" class="custom-control-input" name="type" id="category2" value="2" @if(Session::has('errors')) @if(old('type') == 2) checked @endif @else @if($post->type == 2) checked @endif @endif >
                          <label class="custom-control-label" for="category2">Grant/Fellowship</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                          <input type="radio" class="custom-control-input" name="type" id="category3" value="3" @if(Session::has('errors')) @if(old('type') == 3) checked @endif @else @if($post->type == 3) checked @endif @endif>
                          <label class="custom-control-label" for="category3">Guide</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                          <input type="radio" class="custom-control-input" name="type" id="category4" value="4" @if(Session::has('errors')) @if(old('type') == 4) checked @endif @else @if($post->type == 4) checked @endif @endif>
                          <label class="custom-control-label" for="category4">Work</label>
                        </div>
                      </li>
                    </ul>
                  </div>

                  <div class="card-header border-bottom">
                    <h6 class="m-0">Level</h6>
                  </div>
                  <div class='card-body p-0'>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item p-3">
                        <span class="d-flex mb-2">
                              <select class="form-control" name="level" required>
                                <option selected value="0">Choose...</option>
                                <option value="1" @if(Session::has('errors')) @if(old('level') == 1) selected @endif @else @if($post->level == 1) selected @endif @endif>Degree</option>
                                <option value="2" @if(Session::has('errors')) @if(old('level') == 2) selected @endif @else @if($post->level == 2) selected @endif @endif>Masters</option>
                                <option value="3" @if(Session::has('errors')) @if(old('level') == 3) selected @endif @else @if($post->level == 3) selected @endif @endif>Doctorate</option>
                                <option value="4" @if(Session::has('errors')) @if(old('level') == 4) selected @endif @else @if($post->level == 4) selected @endif @endif>Diploma</option>
                                <option value="5" @if(Session::has('errors')) @if(old('level') == 5) selected @endif @else @if($post->level == 5) selected @endif @endif>General</option>
                              </select>
                              @if ($errors->has('level'))
                                <span class="invalid-feedback">{{ $errors->first('level') }}</span>
                              @endif
                            </span>

                            <span class="d-flex mb-2">
                                  <select id="inputState" name="status" class="form-control">
                                  <option selected value="1" @if(Session::has('errors')) @if(old('status') == 1) selected @endif @else @if($post->status == 1) selected @endif @endif>Publish</option>
                                  <option value="0" @if(Session::has('errors')) @if(old('status') == 0) selected @endif @else @if($post->status == 0) selected @endif @endif>Draft</option>
                                </select>
                        </span>
                          </li>
                        </ul>
                        
                            </div>
                </div>
                <!-- / Post Overview -->
              </div>
              
            </div>
            </form>
@endsection
@section('footer')
@include('layouts.nav.footer')
@endsection
@section('scripts')
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.min.js"></script>
  <script src="/scripts/app/app-blog-new-post.1.1.0.js"></script> -->
  <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=p6857qx7laae1qq3kmov7dwk2m7i3asyi9bl2izt29iz54c8"></script>
  <script>
tinymce.init({
  selector: 'textarea#details',
  height: 520,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tiny.cloud/css/codepen.min.css'
  ]
});
  </script>
  <script src="{{ secure_asset('js/shards.min.js') }}"></script>
  <script src="{{ secure_asset('js/demo.min.js') }}"></script>

  @endsection
