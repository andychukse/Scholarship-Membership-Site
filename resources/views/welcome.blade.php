<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
            <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Scholarships Dev</title>
        <meta name="description" content="Scholarships Dev publishes thousands of verified scholarship and study abroad opportunities for Nigerians">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS Dependencies -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        
        <link rel="stylesheet" href="{{ secure_asset('css/shards.min.css?version=2.1.0') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/shards-extras.min.css?version=2.1.0') }}">
    </head>
    <body class="shards-landing-page--1">
      <!-- Welcome Section -->
      <div class="welcome d-flex justify-content-center flex-column">
        <div class="container">
          <!-- Navigation -->
          <nav class="navbar navbar-expand-lg navbar-dark pt-4 px-0">
            <a class="navbar-brand" href="#">
              <img src="{{ secure_asset('images/landing/logo-white-small.png') }}" class="mr-2" alt="Scholarships Dev">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#our-offer">What We Offer</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#testimonials">Testimonials</a>
                </li>
              </ul>
              @if (Route::has('login'))
              <ul class="navbar-nav ml-auto">

                @auth
                <li class="nav-item">
                  <a class="nav-link" href="{{ secure_url('home') }}"><i class="fas fa-user"></i> Dashboard</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{ secure_url('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i>
                                        {{ __('Logout') }}
                                    </a>
                      <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </li>
                 @else

                <li class="nav-item">
                  <a class="nav-link" href="{{ secure_url('login') }}"><i class="fas fa-user"></i> Login</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ secure_url('register') }}"><i class="fas fa-user"></i> Register</a>
                </li>
                @endif
                    @endauth
              </ul>
              @endif
            </div>
          </nav>
          <!-- / Navigation -->
        </div> <!-- .container -->

        <!-- Inner Wrapper -->
        <div class="inner-wrapper mt-auto mb-auto container">
          <div class="row">
            <div class="col-md-7">
                <h1 class="welcome-heading display-4 text-white">International Scholarships & Grants for Nigerians</h1>
                <p class="text-white">We will provide you access to verified full and partial scholarships with detailed information on how to successfully apply and study abroad.</p>
                <a href="@auth{{ secure_url('subscribe/standard') }}@else{{ secure_url('register') }}@endauth" class="btn btn-lg btn-outline-white btn-pill align-self-center">Subscribe Now</a>
                <small class="sub-amt">Subscription is <i style="text-decoration: line-through; color:#cccccc;">&#8358;12,000</i> <strong>&#8358;5,000/year</strong></small>
            </div>
          </div>
        </div>
        <!-- / Inner Wrapper -->
      </div>
      <!-- / Welcome Section -->

      <!-- Our Services Section -->
      <div id="our-offer" class="our-services section py-4">
        <h3 class="section-title text-center my-5">What We Offer</h3>
        <!-- Features -->
        <div class="features py-4 mb-4">
          <div class="container">
            <div class="row">
              <div class="feature py-4 col-md-6 d-flex">
                <div class="icon text-primary mr-3"><i class="fas fa-user-graduate"></i></div>
                <div class="px-4">
                    <h5>Scholarship and Study Abroad Opportunities</h5>
                    <p>Access to genuine, open scholarship/study abroad opportunities for Nigerians in over 90 countries.</p>
                </div>
              </div>
              <div class="feature py-4 col-md-6 d-flex">
                <div class="icon text-primary mr-3"><i class="fas fa-book"></i></div>
                <div class="px-4">
                    <h5>Detailed Guidelines on Application Processes</h5>
                    <p>Guides on how to apply for each Scholarship to ensure you become successful. Guides on how to gain admission to schools in Europe, US, Asia and the UK where each scholarship is awarded.</p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="feature py-4 col-md-6 d-flex">
                <div class="icon text-primary mr-3"><i class="fas fa-university"></i></div>
                <div class="px-4">
                    <h5>Fellowships, Grants and Research Programmes</h5>
                    <p>Up-to-date International Fellowships, Grants and Funded Research programmes available for Nigerians.</p>
                </div>
              </div>
              <div class="feature py-4 col-md-6 d-flex">
                <div class="icon text-primary mr-3"><i class="fas fa-passport"></i></div>
                <div class="px-4">
                    <h5>VISA and Immigration Guidelines</h5>
                    <p>Necessary Visa information for host countries of each scholarship and application guidelines.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / Features -->
      </div>
      <!-- / Our Services Section -->

      <!-- Subscribe Section -->
      <div class="subscribe section bg-dark py-4 p-2">
        <h3 class="section-title text-center text-white m-5 mx-auto subscribe-head">Scholarship Dev Platform is the most Comprehensive International Scholarship Database for Nigerians looking to gain admission/scholarships, study/research grants for undergraduate and postgraduate study in over 90 countries around the world.</h3>
        <p class="text-muted col-md-6 text-center mx-auto">Want to Win an Amazing Scholarship & Improve your Life?</p>
        
            <div class="col-md-6 col-lg-4 col-sm-9 mx-auto"><a href="@auth{{ secure_url('subscribe/standard') }}@else{{ secure_url('register') }}@endauth" class="btn btn-lg btn-primary btn-outline-white btn-pill d-block mx-auto text-center">Subscribe for &#8358;5,000 per year</a></div>
          
      </div>
      <!-- / Subscribe Section -->

      <!-- Testimonials Section -->
      <div id="testimonials" class="testimonials section py-4">
          <h3 class="section-title text-center m-5">Testimonials</h3>
          <div class="container py-5">
            <div class="row">
                <div class="col-md-4 testimonial text-center">
                    <div class="avatar rounded-circle with-shadows mb-3 ml-auto mr-auto">
                        <img src="{{ secure_asset('images/common/m-avatar.jpg') }}" class="w-100" alt="Testimonial Avatar" />
                    </div>
                    <h5 class="mb-1">Joshua</h5>
                    <span class="text-muted d-block mb-2">Masters</span>
                    <p>Scholarships Dev has been very helpful. I'm currently studying in UK.</p>
                </div>

                <div class="col-md-4 testimonial text-center">
                    <div class="avatar rounded-circle with-shadows mb-3 ml-auto mr-auto">
                        <img src="{{ secure_asset('images/common/m-avatar.jpg') }}" class="w-100" alt="Testimonial Avatar" />
                    </div>
                    <h5 class="mb-1">Tolu</h5>
                    <span class="text-muted d-block mb-2">Masters</span>
                    <p>I highly recommend this platform for anyone looking for oversea scholarships.</p>
                </div>

                <div class="col-md-4 testimonial text-center">
                    <div class="avatar rounded-circle with-shadows mb-3 ml-auto mr-auto">
                        <img src="{{ secure_asset('images/common/f-avatar.jpg') }}" class="w-100" alt="Testimonial Avatar" />
                    </div>
                    <h5 class="mb-1">Mercy</h5>
                    <span class="text-muted d-block mb-2">Bachelors</span>
                    <p> This platform is really informative. Thanks a lot.</p>
                </div>
            </div>
          </div>
      </div>
      <!-- / Testimonials Section -->

      <!-- Contact Section -->
      <div class="contact section-invert py-4">
        <div class="container py-4">
          <div class="row justify-content-md-center px-4">
            <div class=" col-sm-12 col-md-10 col-lg-7 p-4 mb-4 text-center">
                
                <a href="{{ secure_url('register') }}" class="btn btn-lg btn-primary btn-pill ml-auto mr-auto">Get Started Now</a>
              
            </div>
          </div>
        </div>
      </div>
      <!-- / Contact Section -->

      <!-- Footer Section -->
      <footer>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="{{ secure_url('/') }}">Scholarships Dev</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#our-offer">Our Features</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Terms</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Privacy Policy</a>
                </li>
              </ul>
            </div>

          </div>
        </nav>
      </footer>
      <!-- / Footer Section -->

      <!-- JavaScript Dependencies -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

@auth
    <script>
  window.intercomSettings = {
    app_id: "{{ config('view.intercomKey') }}",
    name: "{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}", // Full name
    email: "{{ Auth::user()->email }}", // Email address
    user_id: "{{ Auth::user()->id }}", // User ID
    phone: "{{ Auth::user()->phone }}", // Phone
    @if(!Auth::user()->hasAnyRole(['subscriber']))Plan: "basic subscriber",@endif
    ServiceType: "scholarship",
    created_at: "{{ strtotime(Auth::user()->created_at) }}" // Signup date as a Unix timestamp
  };

</script>
@else

<script>
  window.intercomSettings = {
    app_id: "{{ config('view.intercomKey') }}"
  };
</script>
@endauth
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/{{ config('view.intercomKey') }}';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>

    </body>
</html>
