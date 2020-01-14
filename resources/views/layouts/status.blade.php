@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif