<!doctype html>
<?php
$n = ['nris', 'usa', 'canada', 'australia', 'uk', 'newzealand', 'www'];
$url = explode('.', $_SERVER['HTTP_HOST'])[0];
if (in_array($url, $n)) {$sd = 1;} else { $sd = 0;}

foreach ($n as $k => $v) {
	if ($v == 'nris' || $v = 'www') {
		session(['country_id' => 1]);
	} else {
		session(['country_id' => $k]);
	}
}

?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
     <?php if (isset($meta_title)) {?>
     <title>{{ $meta_title }} | NRIs</title>
   <?php } else {?>
      <title>{{ isset($title) ? trim($title) : '' }} | NRIs</title>
      <?php }?>
         <?php if (isset($meta_keywords)) {?>
     <meta name="keywords" content="{{ isset($meta_keywords) ? $meta_keywords : '' }}">
   <?php } else {?>
     <meta name="keywords" content="{{ isset($keywords) ? $keywords : '' }}">
      <?php }
if (isset($meta_description)) {?>
     <meta name="description" content="{{ isset($meta_description) ? strip_tags($meta_description) : '' }}">
   <?php } else {?>
     <meta name="description" content="{{ isset($description) ? strip_tags($description) : '' }}">
      <?php }
$main_color = request()->req_country ? request()->req_country['color'] : \App\Country::find(1)->first()->color;
$head_color = request()->req_country ? request()->req_country['color'] : \App\Country::find(1)->first()->color;
?>
      <style>
         :root {
         --main-color: <?=$main_color?>;
         --head-color: <?=$head_color?>;
         }
      </style>

      <meta name="author" content="NRIs">

      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:creator" content="www.nris.com">
      <meta name="twitter:site" content="https://www.nris.com/">
      <meta name="twitter:title" content="{{ isset($twitter_title) ? $twitter_title : '' }} | NRIs">
       <meta name="twitter:description" content="{{ isset($description) ? strip_tags($description) : '' }}">
      <meta name="twitter:image:src" content="{{ isset($image_) ? $image_ : '' }}">
      <meta name="twitter:image:width" content="280">
      <meta name="twitter:image:height" content="150">
      <meta property="fb:app_id" content="1882336915317815" />
      <meta property="og:site_name" content="https://www.nris.com/" />
      <meta property="og:title" content="{{ isset($twitter_title) ? $twitter_title : '' }} | NRIS" />
      <meta property="og:description" content="{{ isset($description) ? strip_tags($description) : '' }}" />
      <meta property="og:type" content="xxx:photo">
      <meta property="og:url" content="{{ Request::url() }}" />
      <meta property="og:image" content="{{ isset($image_) ? $image_ : '' }}" />
      <link rel="apple-touch-icon" sizes="57x57" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="60x60" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="72x72" href="https://www.nris.com/stuff/images/fav.png">
      <link rel="apple-touch-icon" sizes="76x76" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="114x114" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="120x120" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="144x144" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="152x152" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="apple-touch-icon" sizes="180x180" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="icon" type="image/png" sizes="192x192"  href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="icon" type="image/png" sizes="32x32" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="icon" type="image/png" sizes="96x96" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="icon" type="image/png" sizes="16x16" href="https://www.nris.com/stuff/images/fav/fav.png">
      <link rel="manifest" href="https://www.nris.com/stuff/images/fav/manifest.json">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="https://www.nris.com/stuff/images/fav/ms-icon-144x144.png">
      <meta name="theme-color" content="#ffffff">
      <meta name="msvalidate.01" content="65DC783115F1E7870C990DC8DC1F7EE0" />
      <meta name="google-site-verification" content="YP0L1k7SDMdqeryKZ-tqwnr7cPofy3xTXiHnVP9lGrU" />
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/line-icons.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/slicknav.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/animate.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/owl.carousel.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/main.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/responsive.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/image-uploader.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/select2.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ url('front/css/select2-bootstrap.min.css') }}" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
         integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
      @stack('css')
      <script src="{{ url('front/js/jquery-min.js') }}"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <!-- <script src="{{ url('front/js/script-top.js') }}"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

            <script>
                 function apply_dp(ele) {
             if (ele == "#expiry_date") {
                 $(ele).datepicker({
                     maxDate: '+28d',
                     minDate: '0',
                     dateFormat: 'dd-mm-yy'
                 })
             }
             if (ele == "#input-next_date") {
                 $(ele).datepicker({
                     maxDate: '+2Y',
                     minDate: '-2Y',
                     dateFormat: 'dd-mm-yy'
                 })
             }
             if (ele == "#start_date") {
                 $(ele).datepicker({
                     dateFormat: 'dd-mm-yy',
                     minDate: '0',
                 })
             }
             if (ele == "#end_date") {
                 $(ele).datepicker({
                     dateFormat: 'dd-mm-yy',
                     minDate: '0',
                 })
             }
         }

         (function($) {
             $.fn.btn = function(action) {
                 var self = $(this);
                 if (action == 'loading') {
                     $(self).addClass("btn-loading");
                 }
                 if (action == 'reset') {
                     $(self).removeClass("btn-loading");
                 }
             }
         })(jQuery);

         function fillCity(state_code, con, selected) {
             $this = $(con);
             if (state_code) {
                 $.ajax({
                     url: '{{ route('front.get_city') }}',
                     type: 'GET',
                     dataType: 'json',
                     data: {
                         state_code: state_code
                     },
                     beforeSend: function() {
                         $(con).prop("disabled", true);
                     },
                     complete: function() {
                         $(con).prop("disabled", false);
                     },
                     success: function(json) {
                         var html = '<option value="">Choose City</option>';
                         $.each(json['lists'], function(i, j) {
                             html +=
                                 `<option ${j.id == selected ? 'selected' : ''} value="${j.id}">${j.name}</option>`;
                         })
                         $(con).html(html)
                     },
                 })
             } else {
                 var html = '<option value="">Choose City</option>';
                 $(con).html(html)
             }
         }

             $(document).ready(function() {

                   setTimeout(function() {
                       $("#alert_error").fadeOut(1500);
                   }, 1000);

                   $('#alert_close').click(function() {
                       $("#alert_error").fadeOut();
                   });
               });



            </script>
   </head>
   <body>
      <!-- {{--<div id="fb-root"></div>--}} -->
      <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v13.0"
         nonce="hvUj1hrn"></script>

      <header id="header-wrap">
          <div
        class="d-block top-bar w-100"
        style="position: fixed; top: 0px; z-index: 9999"
      >
        <div class="custom_container container row mt-1">
          <div class="col-12">
            <ul class="d-flex list-inline ml-lg-3">
              <li>
              <a href="tel:844-435-7674"><i class="fa fa-phone"></i>844-435-7674</a>
              </li>
              <li class="align-items-center d-flex">
                <i class="fa fa-envelope"></i>
                <a href="mailto:info@nris.com">info@nris.com</a>
              </li>

             <li class="align-items-center d-lg-flex d-none">

                <a href="https://nris.com/advertising" style="margin-left: 716px;
    font-size: 14px;
    font-weight: bold;">Advertise with us </a>
              </li>

            </ul>
          </div>
        </div>
      </div>

         <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar bg-white" style="top: 42px;z-index: 99;">
            @if (Route::current()->getName() == 'home')
            <div id="alert_popover1" style="display:none">
               <div class="wrapper_pop d-flex">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="https://www.nris.com/stuff/images/home_logo_icon.png" class="pr-2" alt="">
                  <div class="notification-content">
                     <div class="" id="success-alert"><a href="javascript:void(0)" id="model_close"
                        class="close">×</a>Want to Make Your Body Fit and Strong? Must Eat These 12
                        Healthy Foods!
                     </div>
                  </div>
               </div>
            </div>
            <script>
               $(document).ready(function() {

                   setInterval(function() {
                       $("#alert_popover").fadeIn();
                       setTimeout(function() {
                           $("#alert_popover").fadeOut(1500);
                       }, 5000);
                   }, 10000);

                   $('#model_close').click(function() {
                       $("#alert_popover").fadeOut();
                   });

               });
            </script>
            @endif
            <div class="container">
               <div class="navbar-header">
                  <button style="z-index:999" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
                     aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  <span class="lni-menu"></span>
                  <span class="lni-menu"></span>
                  <span class="lni-menu"></span>
                  </button>
                  <a href="{{ url('/') }}" class="navbar-brand"><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('logo_head.png') }}"
                     alt="Nris"></a>
               </div>
               <div class="collapse navbar-collapse" id="main-navbar">
                  <ul class="navbar-nav w-100 justify-content-center mr-auto text-nowrap">
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-0" href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Our Pages</a>
                        <div class="dropdown-menu">
                           <a class="dropdown-item" href="{{ route('front.nris') }}">NRIS Talk</a>
                           <a class="dropdown-item" href="{{ route('front.forum') }}">Forum</a>
                           <a class="dropdown-item" href="{{ route('front.blog') }}">Blog</a>
                        </div>
                     </li>
                     <li class="nav-item"><a class="nav-link" href="{{ route('realestate.index') }}">Real
                        Estate</a>
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle   pr-1 pl-0" href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Car Pool</a>
                        <div class="dropdown-menu"><a class="dropdown-item"
                                 href="{{ route('front.carpool', 'local') }}">Local</a>
                             <a class="dropdown-item"
                                 href="{{ route('front.carpool', 'interstate') }}">Interstate</a>

                              <a class="dropdown-item"
                                 href="{{ route('front.carpool', 'international') }}">International</a></div>
                     </li>

                     <li class="nav-item"><a class="nav-link" href="{{ route('auto.index') }}">Autos</a>
                     <!--</li>-->

                     <!--</li>-->


                     <li class="nav-item"><a class="nav-link" href="{{ route('educationteaching.index') }}">Education &
                        Teaching</a>
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  pr-1 pl-0 mr-2" href="{{ route('front.videos') }}"
                           aria-haspopup="true" aria-expanded="false">Movies / Videos</a>
                        <div class="dropdown-menu">
                           @foreach (\App\VideoLanguage::all() as $languages)
                           <a class="dropdown-item"
                              href="{{ route('front.videos', $languages->slug) }}">{{ $languages->name }}</a>
                           @endforeach
                        </div>
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  pr-1 pl-0 mr-2" href="javascript:void(0)" data-toggle="collapse"
                           aria-haspopup="true" aria-expanded="false">Free Ads</a>
                        <div class="dropdown-menu">
                           <a class="dropdown-item" href="{{ route('auto.index') }}">Autos</a>
                           <a class="dropdown-item" href="{{ route('front.babysitting.list') }}">Baby
                           Sitting</a>
                           <a class="dropdown-item" href="{{ route('educationteaching.index') }}">Education &
                           Teaching</a>
                           <a class="dropdown-item" href="{{ route('electronics.index') }}">Electronics</a>
                           <a class="dropdown-item" href="{{ route('freestuff.index') }}">Free Stuff</a>
                           <a class="dropdown-item" href="{{ route('garagesale.index') }}">Garage Sale</a>
                           <a class="dropdown-item" href="{{ route('job.index') }}">Jobs</a>
                           <a class="dropdown-item" href="{{ route('front.desi_date') }}">Desi Date</a>
                           <a class="dropdown-item" href="{{ route('room_mate.index') }}">Room Mates</a>
                           <a class="dropdown-item" href="{{ route('realestate.index') }}">Real Estate</a>
                           <!--<a class="dropdown-item" href="{{ route('front.sports.list') }}">Sports</a>-->
                           <a class="dropdown-item" href="{{ route('desi_page.index') }}">Desi Page</a>
                           <a class="dropdown-item" href="{{ route('other.index') }}">Other</a>

                        </div>
                     </li>
                     <?php
if (isset(request()->req_state)) {
	$unive = \App\Student_Talk::where('state_code', request()->req_state['code'])
		->limit(8)
		->get();
}
?>
                     <li class="nav-item dropdown">
                         <!--data-toggle="collapse"-->
                        <a class="nav-link dropdown-toggle  pr-1 pl-0" href="{{ route('adduniversity.index') }}"  aria-haspopup="true"
                           aria-expanded="false"
                           >Student Talk</a>
                           <!--onclick="return CheckLogin(this);"-->
                        @if (request()->req_state)
                        <div class="dropdown-menu">
                           @foreach ($unive as $item)
                           <a class="dropdown-item"
                              href="{{ route('adduniversity.view', ['id' => base64_encode($item['id'])]) }}">{{ $item['uni_name'] }}</a>
                           @endforeach
                        </div>
                        @endif
                     </li>
                  </ul>
               </div>
            </div>
            {{--
            <style>
               #alert_close {
               margin-top: -3px;
               font-size: 31px;
               padding-left: 20px;
               }
               .alert.alert-fixed {
               position: fixed;
               right: 7px;
               min-width: 300px;
               max-width: 100%;
               font-size: 1.5rem;
               font-weight: 500;
               top: 19px;
               }
            </style>
            --}}
            {{-- <?php if (session()->has('success')) {?>
            <div id="alert_error" class="alert alert-success alert-fixed">
               <strong>{{ session()->get('success') }}</strong>
               <a href="javascript:void(0)" id="alert_close" class="close">&times;</a>
            </div>
            <?php }?>
            <?php if (session()->has('error')) {?>
            <div id="alert_error" class="alert alert-danger alert-fixed">
               <strong>{{ session()->get('error') }}</strong>.
               <a href="javascript:void(0)" id="alert_close" class="close">&times;</a>
            </div>
            <?php }?> --}}

            <ul class="mobile-menu">
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle  pr-1 pl-0" href="javascript:void(0)" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">Our Page</a>
                  <ul class="dropdown">
                     <li><a class="dropdown-item" href="{{ route('front.forum') }}">Forum</a></li>
                     <li><a class="dropdown-item" href="{{ route('front.blog') }}">Blog</a></li>
                     <li><a class="dropdown-item" href="{{ route('front.nris') }}">NRI's Talk</a></li>
                  </ul>
               </li>
               <li class="nav-item"><a class="nav-link" href="{{ route('realestate.index') }}">Real
                  Estate</a>
               </li>
               <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  pr-1 pl-0 ml-3" href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Car Pool</a>
                        <div class="dropdown-menu"><a class="dropdown-item"
                                 href="{{ route('front.carpool', 'local') }}">Local</a>
                             <a class="dropdown-item"
                                 href="{{ route('front.carpool', 'interstate') }}">Interstate</a>

                              <a class="dropdown-item"
                                 href="{{ route('front.carpool', 'international') }}">International</a></div>
                     </li>
               <li class="nav-item"><a class="nav-link" href="{{ route('auto.index') }}">Autos</a></li>
               <!--<li class="nav-item"><a class="nav-link" href="{{ route('front.desi_date') }}">Desi-->
               <!--   Date</a>-->
               <!--</li>-->


                        <li class="nav-item"><a class="nav-link" href="{{ route('educationteaching.index') }}">Education &
                  Teaching</a>
               </li>



               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle  pr-1 pl-0" href="{{ route('front.videos') }}" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">Movies / Videos</a>
                  <ul class="dropdown">
                     {{--
                     <li><a class="dropdown-item" href="{{ route('desi_movies.index') }}">Desi Movies</a></li>
                     --}}
                     @foreach (\App\VideoLanguage::all() as $languages)
                     <li><a class="dropdown-item"
                        href="{{ route('front.videos', $languages->slug) }}">{{ $languages->name }}</a>
                     </li>
                     @endforeach
                  </ul>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle  pr-1 pl-0" href="javascript:void(0)" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">Free Ads</a>
                  <ul class="dropdown">
                     <li><a class="dropdown-item" href="{{ route('auto.index') }}">Autos</a></li>
                     <li><a class="dropdown-item" href="{{ route('front.babysitting.list') }}">Baby Sitting</a>
                     </li>
                     <li><a class="dropdown-item" href="{{ route('educationteaching.index') }}">Education &
                        Teaching</a>
                     </li>
                     <li><a class="dropdown-item" href="{{ route('electronics.index') }}">Electronics</a></li>
                     <li><a class="dropdown-item" href="{{ route('freestuff.index') }}">Free Stuff</a></li>
                     <li><a class="dropdown-item" href="{{ route('garagesale.index') }}">Garage Sale</a></li>
                     <li><a class="dropdown-item" href="{{ route('job.index') }}">Jobs</a></li>
                     <li><a class="dropdown-item" href="{{ route('front.desi_date') }}">Desi Date</a></li>
                     <li><a class="dropdown-item" href="{{ route('room_mate.index') }}">Room Mates</a></li>
                     <li><a class="dropdown-item" href="{{ route('realestate.index') }}">Real Estate</a></li>
                     <li><a class="dropdown-item" href="{{ route('other.index') }}">Other</a></li>
                  </ul>
               </li>
               <li class="nav-item">
               </li>
               <a class="nav-link" href="{{ route('adduniversity.index') }}"
                 >Student Talk</a>
                  <!--onclick="return CheckLogin(this);"-->
               </li>
            </ul>
         </nav>
         <div class="top-bar" style="position:relative;top:119px;">
            <div class="custom_container container">
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-6 p-0 ">
                     <div class="d-inline-flex ml-lg-4" style="cursor:pointer;">
                        @include('layouts.country_dropdown', [
                        'con' => request()->req_country ? request()->req_country['name'] : 'USA',
                        ])
                        @include('layouts.state_dropdown', [
                        'state' => request()->req_state ? request()->req_state['name'] : 'State',
                        ])
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-6">
                     <div class="header-top-right-1 text-right mr-lg-4">
                        <?php if (!auth()->check()) {?>
                        <a onclick="auth('login')" href="javascript:void(0)" class="header-top-button"><i
                           class="fa fa-lock"></i><span class="d-none d-sm-inline-block pl-1"> Log
                        In</span> </a> |
                        <a onclick="auth('register')" href="javascript:void(0)" class="header-top-button"><i
                           class="fa fa-pencil"></i><span class="d-none d-sm-inline-block pl-lg-1">
                        Register</span></a>
                        <?php } else {?>
                        <a href="{{ route('front.profile') }}" class="d-inline-block header-top-button">
                        <?php if (Auth::check()) {?>
                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="pro-img" src="{{ auth()->user()->image_url }}" alt="">
                        <?php }?>
                        {{-- <span><i class="fa fa-user-circle"></i></span> --}}
                        <span class="hide_on_sm pl-1"> Welcome {{ auth()->user()->first_name }}</span> </a>
                        <a class="header-top-button" href="{{ route('front.logout') }}">
                        <i class="fa fa-sign-out"></i><span> Logout </span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                        <?php }?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php if (\Route::currentRouteName() == 'home' || \Route::currentRouteName() == 'home.gifdata') {?>
<div class="gifdata-api">
    <div class="loader"></div>
</div>
<?php }?>

      </header>

      @yield('content')
      <section class="subscribes section-padding border-top mt-1 py-2">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="subscribes-inner">
                     <div class="icon">
                        <i class="fa fa-paper-plane"></i>
                     </div>
                     <div class="sub-text">
                        <h3>Subscribe to Newsletter</h3>
                        <p>and receive new ads in inbox</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <form id="subscribe-form" action="{{ route('front.subscribe_newsletter.submit') }}">
                     @csrf
                     <div class="subscribe">
                        <input class="form-control" name="email" placeholder="Enter your Email"
                           type="text">
                        <button class="btn btn-common btn-submit" id="subscribe-newsletter"
                           type="submit">Subscribe</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </section>
      <footer>
         <section class="footer-Content">
            <div class="container">
               <div class="row">
                  <div class="col-lg-5 col-md-5 col-xs-6 col-mb-12">
                     <div class="widget">
                        <div class="footer-logo"><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="w-50"
                           src="https://www.nris.com/stuff/images/home_logo_icon.png" alt=""></div>
                        <div class="textwidget">
                           <p>NRIS.COM is one of the premier NRI websites that provides a range of resourceful
                              services to Indian expats residing in the USA. Visiting the site you will find
                              comprehensive information related to restaurants, casinos, pubs, temples, carpool,
                              movies, education, real estate, and forums. The simple and easy to navigate format
                              allows NRIs to gain information within a fraction of a second. Moreover, advertising
                              through its column of Indian free classifieds in USA allow businesses to improve
                              visibility of their brand.
                           </p>
                           <h2 class="bg-danger text-light text-capitalize mt-3 p-1"> If you see any copyrighted
                              information please email us at <a href="mailto:copyrightsnris@gmail.com"
                                 class="text-black"><u class="text">copyrightsnris@gmail.com</u></a>
                           </h2>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-6 col-mb-12">
                     <div class="widget">
                        <h3 class="block-title mb-0">Quick Link</h3>
                        <ul class="menu">
                           {{--
                           <li><a href="mailto:nris@gmail.com">- Advertise with us</a></li>
                           --}}
                           <li><a href="{{ route('front.aboutus') }}">- About Us</a></li>
                           <li><a href="{{ route('front.termscondition') }}">- Terms & Conditions</a></li>
                           <li><a href="{{ route('front.disclaimer') }}">- Disclaimer</a></li>
                           <li><a href="{{ route('front.advertising') }}">- Advertise</a></li>
                           <li><a href="mailto:nris@gmail.com">- Contact</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-6 col-mb-12">
                     <div class="widget">
                        <h3 class="block-title mb-0">Contact Info</h3>
                        <ul class="contact-footer">
                           <li>
                              <strong>Partnership enquiries contact us at </strong>
                              <span class="m-0">
                              <a href="mailto:info@nris.com">info@nris.com</a>
                              </span>
                           </li>
                           <li class="pb-0">
                              <strong>Business Enquiries contact us at</strong>
                              <span class="m-0">
                              <a href="mailto:contact@nris.com">contact@nris.com</a>
                              </span>
                           </li>
                        </ul>
                        <ul class="footer-social mt-4 mb-3">
                           <li><a target="_blank" class="facebook"
                              href="https://www.facebook.com/NRIscom-1684062268585350/"><i
                              class="fa fa-facebook-f"></i></a></li>
                           <li><a target="_blank" class="twitter" href="https://twitter.com/thenrisus"><i
                              class="fa fa-twitter"></i></a></li>
                           <li><a target="_blank" class="pinterest" href="https://pinterest.com/thenris395/"><i
                              class="fa fa-pinterest-p"></i></a>
                           </li>
                        </ul>
                        <div class="main-button">
                           <p> Get <strong>NRIS Card</strong> for $10 and enjoy the services. So Hurry Up!! Get
                              Your
                           </p>
                           <a href="{{ route('membership.index') }}">Card Now</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <div id="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <div class="site-info text-center">
                        <p>Copyright © <?=date('Y')?> nris.com</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <script>
         $(".main-button").click(function() {
             window.location = "{{ url('nris-card') }}"
         })
      </script>
      <a href="#header-wrap" class="back-to-top"><i class="fa fa-angle-up"></i></a>
      <!-- <div id="preloader">
         <div class="loader" id="loader-1"></div>
         </div> -->
      <?php if (!auth()->check()) {?>
      <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel"
         aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content m-t-124">
               <div class="container-login" id="container-login">
                  <div class="form-container sign-up-container">
                     <form action="{{ route('front.register') }}">
                        @csrf
                        <h1 class="mb-1">Create Account</h1>
                        <div class="row">
                           <div class="col-12 col-sm-6">
                              <div class="form-group">
                                 <label>First Name</label>
                                 <input name="first_name" class="form-control" type="text"
                                    placeholder="First Name">
                              </div>
                           </div>
                           <div class="col-12 col-sm-6">
                              <div class="form-group">
                                 <label>Last Name</label>
                                 <input name="last_name" class="form-control" type="text"
                                    placeholder="Last Name">
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label>Email</label>
                           <input name="email" class="form-control" type="text" placeholder="Email">
                        </div>
                        <div class="form-group">
                           <label>Date of birth</label>
                           <input name="dob" id="register-dob" autocomplete="autocomplete_off_hack_xfr4!k"
                              class="form-control" type="text" placeholder="Date of birth">
                        </div>
                        <div class="form-group">
                           <label>Password</label>
                           <input name="password" class="form-control" type="password" placeholder="Password">
                        </div>
                        {{--
                        <div class="row">
                           <div class="col-6">
                              --}}
                              <div class="form-group">
                                 <select class="form-control" name="country" id="country-dropdown">
                                    <option value="">Select Country</option>
                                    @foreach (\App\Country::all() as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              {{--
                           </div>
                           --}}
                           {{--
                           <div class="col-6">
                              --}}
                              <div class="form-group">
                                 <select class="form-control" name="state" id="state-dropdown">
                                    <option value="">Select state</option>
                                 </select>
                              </div>
                              {{--
                           </div>
                           --}}
                           {{--
                        </div>
                        --}}
                        <script>
                           $('#country-dropdown').on('change', function() {
                               var country_id = this.value;
                               $("#state-dropdown").html('');
                               $.ajax({
                                   url: "{{ url('get-states-by-country') }}",
                                   type: "POST",
                                   data: {
                                       country_id: country_id,
                                       _token: '{{ csrf_token() }}'
                                   },
                                   dataType: 'json',
                                   success: function(result) {
                                       $('#state-dropdown').html('<option value="">Select State</option>');
                                       $.each(result.states, function(key, value) {
                                           $("#state-dropdown").append('<option value="' + value.code + '">' +
                                               value
                                               .name + '</option>');
                                       });
                                       $('#city-dropdown').html('<option value="">Select State First</option>');
                                   }
                               });
                           });
                        </script>
                        <div class="form-group">
                           <label>
                           <input name="agree" type="checkbox" name=""> I agree with <a href="{{ route('front.termscondition') }}">Terms &
                           Conditions</a>
                           </label>
                        </div>
                        <button type="button" class="btn btn-signup btn-common mb-2">Sign Up</button>
                     </form>
                  </div>
                  <div class="form-container sign-in-container">
                     <form id="loginform" class="register-form" action="{{ route('front.login') }}">
                        @csrf
                        <h1 class="mb-1">Sign in</h1>
                        <div class="form-group">
                           <label>Email</label>
                           <input name="email" type="text" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                           <label>Password</label>
                           <input name="password" type="password" class="form-control"
                              placeholder="Enter Password">
                        </div>
                        <div class="form-group mb-3">
                           <div class="custom-control custom-checkbox">
                              <input name="remember" value="true" type="checkbox"
                                 class="custom-control-input" id="checkedall">
                              <label class="custom-control-label" for="checkedall">Keep me logged in</label>
                           </div>
                        </div>
                        <a href="javascript:void(0)" onclick="forgotpassword()">Forgot your password?</a>
                        <button type="button" class="btn btn-signin btn-common mt-3">Sign In</button>
                     </form>
                  </div>
                  <div class="overlay-container">
                     <div class="overlay">
                        <div class="overlay-panel overlay-left">
                           <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="w-75 mb-sm-5 mb-3" src="https://www.nris.com/stuff/images/home_logo_icon.png">
                           <h1 class="text-white">Welcome Back!</h1>
                           <p class="text-white-50">To keep connected with us please login with your personal info
                           </p>
                           <button class="btn btn-common mt-3" id="signIn">Sign In</button>
                           <!--<div class="row mt-3">-->
                           <!--   <div class="col-12">-->
                           <!--      <h5 class="mb-3 text-light" style="font-size: 20px">Sign In With</h5>-->
                           <!--   </div>-->
                              <!--<div class="col-6 border-right text-right">-->
                              <!--   <a href="{{ url('auth/google') }}" class="mt-3">-->
                              <!--   <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('google.png') }}" title="Sign In With Google"-->
                              <!--      alt="Sign In With Google">-->
                              <!--   </a>-->
                              <!--</div>-->
                              <!--<div class="col-6 text-left">-->
                              <!--   <a class="fb-btn" href="{{ url('') }}" class="mt-3">-->
                              <!--   <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('facebook.png') }}" title="Sign In With FaceBook"-->
                              <!--      alt="Sign In With FaceBook">-->
                              <!--   </a>-->
                              <!--</div>-->
                           <!--</div>-->
                        </div>
                        <div class="overlay-panel overlay-right">
                           <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="w-75 mb-30" src="https://www.nris.com/stuff/images/home_logo_icon.png">
                           <h1 class="text-white">Hello, Friend!</h1>
                           <p class="text-white-50">Enter your personal details and start journey with us</p>
                           <button class="btn btn-common mt-3" id="signUp">Sign Up</button>
                           <!--<div class="row mt-3">-->
                           <!--   <div class="col-12" >-->
                           <!--      <h5 class="mb-3 text-light" style="font-size: 20px">Sign In With</h5>-->
                           <!--   </div>-->
                              <!--<div class="col-6 border-right text-right">-->
                              <!--   <a href="{{ url('auth/google') }}" class="mt-3">-->
                              <!--   <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('google.png') }}" title="Sign In With Google"-->
                              <!--      alt="Sign In With Google">-->
                              <!--   </a>-->
                              <!--</div>-->
                              <!--<div class="col-6 text-left">-->
                              <!--   <a class="fb-btn" href="{{ url('auth/facebook') }}" class="mt-3">-->
                              <!--   <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('facebook.png') }}" title="Sign In With FaceBook"-->
                              <!--      alt="Sign In With FaceBook">-->
                              <!--   </a>-->
                              <!--</div>-->
                           <!--</div>-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <div id="forgotModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content m-t-124">
               <div class="modal-header">
                  <h2 class="modal-title" id="my-modal-title">Forgot password</h2>
                  <button class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form class="forgot-password-form" action="{{ route('front.forgotpassword') }}">
                     @csrf
                     <div class="form-group">
                        <label class="control-label">Email</label>
                        <input name="email" type="text" class="form-control" placeholder="Enter Email">
                     </div>
                     <div class="form-group">
                        <button type="button" class="btn btn-common" id="forgotPass">Submit</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         $("#register-dob").datepicker({
             dateFormat: 'dd-mm-yy',
             maxDate: '0y',
             changeMonth: true,
             changeYear: true,
             yearRange: "-100:+0",
         })

         const signUpButton = document.getElementById('signUp');
         const signInButton = document.getElementById('signIn');
         const container = document.getElementById('container-login');

         signUpButton.addEventListener('click', function() {
             container.classList.add("right-panel-active");
         });

         signInButton.addEventListener('click', function() {
             container.classList.remove("right-panel-active");
         });

         function auth(type) {
             $("#authModal").modal("show")
             if (type == 'login') {
                 container.classList.remove("right-panel-active");
             } else {
                 container.classList.add("right-panel-active");
             }
         }

         function forgotpassword() {
             $("#authModal").modal("hide")
             setTimeout(function() {
                 $("#forgotModal").modal("show")
             }, 100);
         }

         $("#authModal").on('shown.bs.modal', function() {
             $(this).find(".alert-dismissable").remove();
             $(this).find(".is-invalid").removeClass('is-invalid');
             $(this).find(".has-error").removeClass('has-error');
         })

         $('#loginform input').keypress(function(e) {
             if (e.keyCode == 13) {
                 $this = $(this);
                 $.ajax({
                     url: $(".sign-in-container form").attr("action"),
                     type: 'POST',
                     dataType: 'json',
                     data: new FormData($(".sign-in-container form")[0]),
                     processData: false,
                     contentType: false,
                     beforeSend: function() {
                         $this.btn("loading");
                     },
                     complete: function() {
                         $this.btn("reset");
                     },
                     success: function(json) {
                         json_response(json, $(".sign-in-container form"));
                       //  console.log(json)
                         if (json.success) {
                             if (window.indendURL) {
                                 window.location.href = window.indendURL;
                             } else {
                                 window.location.reload()
                             }
                         }
                     }
                 })

                 return false;
             }
         })

         $(".btn-signin").click(function() {
             $this = $(this);
             $.ajax({
                 url: $(".sign-in-container form").attr("action"),
                 type: 'POST',
                 dataType: 'json',
                 data: new FormData($(".sign-in-container form")[0]),
                 processData: false,
                 contentType: false,
                 beforeSend: function() {
                     $this.btn("loading");
                 },
                 complete: function() {
                     $this.btn("reset");
                 },
                 success: function(json) {
                     json_response(json, $(".sign-in-container form"));
                   //  console.log(json)
                     if (json.success) {
                         if (window.indendURL) {
                             window.location.href = window.indendURL;
                         } else {
                             window.location.reload()
                         }
                     }
                 },
             })

             return false;
         })

         $(".btn-signup").click(function() {
             $this = $(this);
             $.ajax({
                 url: $(".sign-up-container form").attr("action"),
                 type: 'POST',
                 dataType: 'json',
                 data: new FormData($(".sign-up-container form")[0]),
                 processData: false,
                 contentType: false,
                 beforeSend: function() {
                     $this.btn("loading");
                 },
                 complete: function() {
                     $this.btn("reset");
                 },
                 success: function(json) {
                     json_response(json, $(".sign-up-container form"));
                 },
             })

             return false;
         })

         // forgotPass
         $("#forgotPass").click(function() {
            // console.log(4145);
             $this = $(this);
             $.ajax({
                 url: $(".forgot-password-form").attr("action"),
                 type: 'POST',
                 dataType: 'json',
                 data: new FormData($(".forgot-password-form")[0]),
                 processData: false,
                 contentType: false,
                 beforeSend: function() {
                     $this.btn("loading");
                 },
                 complete: function() {
                     $this.btn("reset");
                 },
                 success: function(json) {
                     json_response(json, $(".forgot-password-form"));
                 },
             })

             return false;
         })
      </script>
      <?php }?>
      <!-- <div id="live-chat">
         <header class="clearfix">
             <a href="#" class="chat-close">x</a>
             <h4>John Doe</h4>
             <span class="chat-message-counter">3</span>
         </header>
         <div class="chat" style="display: none;">
             <div class="chat-history">
                 <div class="chat-message clearfix">
                     <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  asrc="/32/32/people" alt="" width="32" height="32">
                     <div class="chat-message-content clearfix">
                         <span class="chat-time">13:35</span>
                         <h5>John Doe</h5>
                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, explicabo quasi ratione odio
                             dolorum harum.</p>
                     </div>
                 </div>
                 <hr>
                 <div class="chat-message clearfix">
                     <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="http://gravatar.com/avatar/2c0ad52fc5943b78d6abe069cc08f320?s=32" alt="" width="32"
                         height="32">
                     <div class="chat-message-content clearfix">
                         <span class="chat-time">13:37</span>
                         <h5>Marco Biedermann</h5>
                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, nulla accusamus magni
                             vel debitis numquam qui tempora rem voluptatem delectus!</p>
                     </div>
                 </div>
                 <hr>
                 <div class="chat-message clearfix">
                     <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  asrc="/32/32/people" alt="" width="32" height="32">
                     <div class="chat-message-content clearfix">
                         <span class="chat-time">13:38</span>
                         <h5>John Doe</h5>
                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                     </div>
                 </div>
                 <hr>
             </div>
             <p class="chat-feedback">Your partner is typing…</p>
             <form action="#" method="post">
                 <fieldset>
                     <input type="text" placeholder="Type your message…" autofocus>
                     <input type="hidden">
                 </fieldset>
             </form>
         </div>
         </div> -->
      <div id="state-selection" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content m-t-124">
               <div class="modal-header">
                  <h2 class="modal-title" id="my-modal-title">Select State</h2>
                  <button class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <p>Content</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         (function($) {
             $("#live-chat header").on("click", function() {
                 $(".chat").slideToggle(300, "swing");
                 $(".chat-message-counter").fadeToggle(300, "swing");
             });

             $(".chat-close").on("click", function(e) {
                 e.preventDefault();
                 $("#live-chat").fadeOut(300);
             });
         })(jQuery);
      </script>
      <script src="{{ url('front/js/popper.min.js') }}"></script>
      <script src="{{ url('front/js/bootstrap.min.js') }}"></script>
      <script src="{{ url('front/js/jquery.counterup.min.js') }}"></script>
      <script src="{{ url('front/js/waypoints.min.js') }}"></script>
      <script src="{{ url('front/js/wow.js') }}"></script>
      <script src="{{ url('front/js/owl.carousel.min.js') }}"></script>
      <script src="{{ url('front/js/jquery.slicknav.js') }}"></script>
      <script src="{{ url('front/jquery.da-share.js') }}"></script>
      <script src="{{ url('front/js/image-uploader.min.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
         integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
         crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="{{ url('notification/jquery.notify.js') }}"></script>
      <link href="{{ url('notification/jquery.notify.css') }}" rel="stylesheet">
      <script src="{{ url('front/js/main.js') }}"></script>
      @stack('scripts')

      <script type="text/javascript">

         <?php if (session()->has('success')) {?>
         $.notify({
             position: 8,
             type: 'success',
             autoClose: true,
             message: `{{ session()->get('success') }}`
         });

         $(".page-header .breadcrumb-wrapper").after(
             '<div class="alert alert-success">{{ session()->get('success') }}</div>')
         <?php }?>

         <?php if (session()->has('error')) {?>
         $.notify({
             position: 8,
             type: 'success',
             autoClose: true,
             message: `{{ session()->get('error') }}`
         });

         $(".page-header .breadcrumb-wrapper").after(
             '<div class="alert alert-error">{{ session()->get('error') }}</div>')
         <?php }?>
      </script>
    <!-- <script src="{{ url('front/js/custom.js') }}"></script> -->

    <script type="text/javascript">
          $('.mobile-menu').slicknav({
             prependTo: '.navbar-header',
             parentTag: 'liner',
             allowParentLinks: true,
             duplicate: true,
             label: '',
             closedSymbol: '<i class="lni-chevron-right"></i>',
             openedSymbol: '<i class="lni-chevron-down"></i>',
         });

  function showAlert(e) {
             $(".image-uploader").parent().after(
                 "<div class='alert alert-size mt-1 alert-danger'>Max file size 200KB allowd</div>");
         }


         var currentTime = (new Date()).getTime();
         $("[data-time]").each(function(i, j) {
             var _open = $(this).attr("_open");
             var close = $(this).attr("close");

             if (_open && close) {
                 if (currentTime > (new Date(_open)).getTime() && currentTime < (new Date(close)).getTime()) {
                     $(this).html("Open");
                     $(this).addClass("bg-success");
                 } else {
                     $(this).html("Close");
                     $(this).addClass("bg-danger");
                 }
             }
         })



  $(document).ajaxError(function myErrorHandler(event, xhr, ajaxOptions, thrownError) {
             if (xhr.status == 401) {
                 auth('login');
             }
             if (xhr.status == 419) {
                 $.notify({
                     position: 8,
                     type: 'error',
                     autoClose: true,
                     message: 'CSRF token mismatch.'
                 });
             }
         });

         var json_response = function(json, container) {
             $container = $(container);

             $container.find(".alert-dismissable").remove();
             $container.find(".is-invalid").removeClass('is-invalid');
             $container.find(".has-error").removeClass('has-error');

             if (json['errors']) {
                 $.notify({
                     position: 8,
                     type: 'success',
                     autoClose: true,
                     message: "Please fix all errors"
                 });
                 $.each(json['errors'], function(i, j) {
                     $ele = $container.find('[name="' + i + '"]');

                     if ($ele) {
                         $ele.addClass('is-invalid');
                         $ele.parents(".form-group").addClass("has-error");
                       //  console.log(j);


                         if ($ele.attr('type') == 'checkbox') {
                             $ele.parents(".form-group").append(
                                 "<span class='d-block text-danger alert-dismissable'>" + j + "</span>");
                         } else {
                             $ele.after("<span class='text-danger alert-dismissable'>" + j + "</span>");
                         }
                     }
                 })
             }

             if (json['location']) {
               //  console.log(json['location']);
                 window.location = json['location'];
             }

             if (json['success_message']) {
                 $.notify({
                     position: 8,
                     type: 'success',
                     autoClose: true,
                     message: json['success_message']
                 });
             }

             if (json['error_message']) {
                 $.notify({
                     position: 8,
                     type: 'error',
                     autoClose: true,
                     message: json['error_message']
                 });
             }

             if (json['reload']) {
                 window.location.reload();
             }
         };
         $(function() {
             $("#subscribe-form").submit(function() {
                 $this = $(this);
                 $.ajax({
                     url: $this.attr("action"),
                     type: 'POST',
                     dataType: 'json',
                     data: new FormData($this[0]),
                     processData: false,
                     contentType: false,
                     beforeSend: function() {
                         $this.find(".btn-submit").btn("loading");
                     },
                     complete: function() {
                         $this.find(".btn-submit").btn("reset");
                     },
                     success: function(json) {
                         json_response(json, $this);
                     },
                 })

                 return false;
             })
         });

         function state(url, type, add_name = '') {

            //  console.log(url);
            //   console.log(type);
            //   console.log(add_name);
            // console.log(  url.indexOf("blog-from") )

             $.ajax({
                 type: "post",
                 url: "{{ route('front.setStateAdd') }}",
                 data: {
                     _token: '{{ csrf_token() }}',
                     url: url,
                     type: type,
                     add_name: add_name
                 },
                 dataType: 'json',
                 beforeSend: function() {
                     $('#state-selection .modal-body .row').html(
                         '<div class="col-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>'
                     );
                 },
                 success: function(json) {
                     html = '';
                     if (json.hrefs) {
                         $.each(json.hrefs, function(i, j) {
                             html += '<div class="col-md-4 col-sm-6 mt-1"><a href="' + j.link +
                                 '" class="h3">' + j.state_name + '</a></div>';
                         });
                     }
                     $('#state-selection .modal-body .row').html(html);
                     $('#state-selection .modal-header .modal-title').text('Select State');
                     $('#state-selection').modal('show');
                 }
             });
         }

         function LoginFrom(this_){
             var logincheck = "{{ Auth::check() }}";
             if (!logincheck) {
                 auth("login");
                 return false;
             }
         }

         function CheckLogin(this_) {
             var url = $(this_).attr("href");
             var type = (url.indexOf("create_free_ad") > -1) ? "create_free_ad" : "create_premium_ad";
             window.indendURL = url;

             var check = "{{ Auth::check() }}";
             var check_state = '{{ request()->req_state ? true : false }}';
             if (!check) {
                 auth("login");
                 return false;
             } else if (!check_state) {
                 state(url, type);
                 return false;
             } else {
                 window.location.href = url;
             }
         }

         $('.select_state').select2({
             tags: true
         });

         $('.select_state').on('select2:select', function(e) {
             url = e.params.data?.element.dataset.url ? e.params.data.element.dataset.url : '';
             if (url) {
                 window.location.href = url;
             }
         });

         $(function() {
             function setAjaxDropDown(element, attr, url) {
                 $(element).select2({
                     width: '100%',
                     closeOnSelect: true,
                     placeholder: "Select a City",
                     ajax: {
                         url: url,
                         dataType: 'json',
                         delay: 250,
                         data: function(query) {
                             return {
                                 ...query,
                                 name: attr
                             };
                         },
                         processResults: function(data) {
                             var newObj = Object.values(data).map(function(i, j) {
                                 return {
                                     id: i.id,
                                     text: i.name,
                                 }
                             });
                             return {
                                 results: newObj
                             };
                         },
                     },
                     templateResult: formatResult
                 });
             };

             function formatResult(d) {
                 if (d.loading) {
                     return d.text;
                 }
                 $d = $('<option/>').attr({
                     'value': d.id
                 }).text(d.text);
                 return $d;
             }
             setAjaxDropDown($(".city_dropdown"), 'city_code', '{{ route('city.autodropdown') }}');
         });

         $(".like-form-list .btn").on('click', function() {
             $this = $(this);
             $form = $this.parents('.like-form-list')


             var formData = new FormData($form[0]);
             formData.append('status', $this.hasClass("btn-like"));

             $.ajax({
                 url: $form.attr("action"),
                 type: 'POST',
                 dataType: 'json',
                 data: formData,
                 processData: false,
                 contentType: false,
                 beforeSend: function() {
                     $this.btn("loading");
                 },
                 complete: function() {
                     $this.btn("reset");
                 },
                 success: function(json) {
                     json_response(json, $this);

                     $form.parents('.like-container').removeClass('liked')
                     $form.parents('.like-container').removeClass('disliked')

                     if (json.status == '1') {
                         $form.parents('.like-container').addClass('liked');
                     } else if (json.status == '0') {
                         $form.parents('.like-container').addClass('disliked');
                     }

                     $form.find('.btn-like span').html(json.totals[1])
                     $form.find('.btn-dislike span').html(json.totals[0])
                 },
             })

             return false;
         })

         $(document).ready(function() {
             $(".fancybox").fancybox();
         });
         $('.back-to-top').click(function(){
             scrollToTop();

         });
         function scrollToTop() {
            window.scrollTo(0, 0);
        }

    </script>

<!--<script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js"></script>-->

<!-- Add Firebase products that you want to use -->
<!--<script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging.js"></script>-->


<script>
//   var firebaseConfig = {
//     apiKey: "AIzaSyBhU5Vq4yczQ9Cr-tIBbMtyfiu-kD4r7Dw",
//     authDomain: "nris-371507.firebaseapp.com",
//     projectId: "nris-371507",
//     storageBucket: "nris-371507.appspot.com",
//     messagingSenderId: "694500506275",
//     appId: "1:694500506275:web:053114cfba67f501475d16",
//     measurementId: "G-RLFMH8DM02"
//   };




//   // Initialize Firebase
//   firebase.initializeApp(firebaseConfig);

//   const messaging = firebase.messaging();
// messaging.requestPermission()
//   .then(function () {
//     console.log('Permission granted.');
//   })
//   .catch(function (error) {
//     console.log('Permission denied.', error);
//   });



	$('*').on('keyup', function() { // Listen for keyup events on all input elements
				var input = $(this).val(); // Get the current value of the input
				if(/[ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ]/.test(input)) { // Test if the input contains any Spanish letters
				alert(' Spanish letters not allowed ')
			title = input.replace(/[ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ]/g, ''); // Remove Spanish letters
			$(this).val(title);
				}
			});


</script>




   </body>
</html>