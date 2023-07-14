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

           
         </nav>
         

      </header>

      
      
      
      
@section('content')
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="row"></div>
<div class="row"></div>
<div class="row"></div>
<div class="row"></div>
<div class="row"></div>
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header" style="text-align:center">Reset Password</div>

                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif




                    <div class="card-body">
    
                        <form action="{{ route('change.forgot.password') }}" method="POST">
                            @csrf
                            <div class="form-group row">                                
                                <div class="col-md-6">
                                    <input type="hidden" id="email_address" class="form-control" name="email" value="{{ $email }}" readonly>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required autofocus>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-common btn-submit">
                                    Update Password
                                </button>
                            </div>
                        </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection


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
                           <li><a href="{{ route('front.privacy') }}">- Privacy</a></li>
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
