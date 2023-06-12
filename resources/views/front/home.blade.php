
<?php
$n = ['nris', 'canada', 'australia', 'uk', 'newzealand'];
$url = explode('.', $_SERVER['HTTP_HOST'])[0];

//print_r($url);

if (in_array($url, $n)) {$sd = 1;} else { $sd = 0;}
?>
<input type="hidden" class="current_country_id" value="<?=$current_country_id;?>" >
<input type="hidden" class="current_state" value="<?=$state_name;?>" >

@extends('layouts.front', $meta_tags)

@section('content')


<!--<style>-->
<!--.loader {-->
<!--  border: 16px solid #f3f3f3;-->
<!--  border-radius: 50%;-->
<!--  border-top: 16px solid #3498db;-->
<!--  width: 120px;-->
<!--  height: 120px;-->

<!--  animation: spin 2s linear infinite;-->
<!--}-->


<!--@-webkit-keyframes spin {-->
<!--  0% { -webkit-transform: rotate(0deg); }-->
<!--  100% { -webkit-transform: rotate(360deg); }-->
<!--}-->

<!--@keyframes spin {-->
<!--  0% { transform: rotate(0deg); }-->
<!--  100% { transform: rotate(360deg); }-->
<!--}-->
<!--</style>-->

<style>
.loader::before {
  content: '';
  left: 0;
  top: 0;
  position: absolute;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: #FFF;
  background-image: radial-gradient(circle 8px at 18px 18px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 18px 0px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 0px 18px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 36px 18px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 18px 36px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 30px 5px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 30px 5px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 30px 30px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 5px 30px, var(--base-color) 100%, transparent 0), radial-gradient(circle 4px at 5px 5px, var(--base-color) 100%, transparent 0);
  background-repeat: no-repeat;
  box-sizing: border-box;
  animation: rotationBack 3s linear infinite;
}
.loader::after {
  content: '';
  left: 35px;
  top: 15px;
  position: absolute;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background-color: #FFF;
  background-image: radial-gradient(circle 5px at 12px 12px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 12px 0px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 0px 12px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 24px 12px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 12px 24px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 20px 3px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 20px 3px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 20px 20px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 3px 20px, var(--base-color) 100%, transparent 0), radial-gradient(circle 2.5px at 3px 3px, var(--base-color) 100%, transparent 0);
  background-repeat: no-repeat;
  box-sizing: border-box;
  animation: rotationBack 4s linear infinite reverse;
}
@keyframes rotationBack {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(-360deg);
  }
}
</style>

    <script type="text/javascript" src="{{ url('front/slider/js/lightslider.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('front/slider/css/lightslider.min.css') }}">

    <section class="d-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 mb-1 text-right d-none">
                    <button type="button" class="btn btn-success ads_btn_free px-2 py-1">Create Free ad</button>
                    <button type="button" class="btn btn-danger ads_btn_pre px-2 py-1">Create Premium ad</button>
                </div>
                <div class="col-sm-12 d-none">
                    <marquee direction="right" width="100%" height="95px">
                        <div id="data-slider" class="data-wrapper d-flex">
                            <?php
$ads = array();
foreach ($ads as $key => $ad) {
	$date1 = new DateTime($ad->sdate);
	$date2 = new DateTime($ad->edate);
	$interval = $date1->diff($date2);
	if ($ad->image_url) {
		if ($interval->y !== 0 || $interval->m !== 0 || $interval->d !== 0) {?>
                             <div class="item mb-3 mr-3 ml-3">
                                <a href="{{ $ad->url }}" target="_blank">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"   src="{{ $ad->image_url }}" alt="">
                                </a>
                            </div>
                            <?php }}}?>
                        </div>
                    </marquee>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12 px-lg-1 recent-ads recent-ads-api">
                            <div class="loader"></div>

                         </div>
                        <div class="col-lg-6 col-12 px-lg-1 nris-ads-api">
                              <div class="loader"></div>

                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('.ads_btn_free').click(function(e) {
                                @if (!request()->req_state)
                                    $('#state-selection_ads').modal('show');
                                @else
                                    $('#exampleModalCenter_free').modal('show');
                                @endif
                            });

                            $('.ads_btn_pre').click(function(e) {
                                @if (!request()->req_state)
                                    $('#state-selection_ads').modal('show');
                                @else
                                    $('#exampleModalCenter_pre').modal('show');
                                @endif
                            });
                        });
                    </script>
                    <?php
$coun = request()->req_country ? request()->req_country['id'] : '1';
$main_coun = \App\State::where('country_id', $coun)->get();
?>
                    <div id="state-selection_ads" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        @foreach ($main_coun as $con_val)
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <a href="http://{{ str_replace(' ', '', $con_val['name']) }}.nris.com"
                                                    class="h3">{{ $con_val['name'] }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModalCenter_free" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content m-t-124">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLongTitle">Select Free Ads Category</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-block home_small_icon">
                                        <ul class="list-inline">
                                            <div class="row">
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.national_autos.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/auto.png') }}"
                                                            alt="box_office_icon" class="" width="60">
                                                        <span class="d-block">Auto</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.babysitting.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/baby-sitting.png') }}"
                                                            alt="restaurants_icon" class="" width="60">
                                                        <span class="d-block">Baby Sitting</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.education.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/education.png') }}"
                                                            alt="temple_icon" class="" width="60">
                                                        <span class="d-block">Education & <br> Teaching</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.electronics.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/electronics.png') }}"
                                                            alt="pub_icon" class="" width="60">
                                                        <span class="d-block">Electronics</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.freestuff.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/others.png') }}" alt="casinos_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Free Stuff</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.garagesale.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/gradge-sale.png') }}"
                                                            alt="restaurants_icon" class="" width="60">
                                                        <span class="d-block">Garage Sale</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.job.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/jobs.png') }}" alt="temple_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Jobs</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.desidate.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/desi-dates.png') }}" alt="pub_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Desi Meet</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.roommate.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/roommates.png') }}" alt="pub_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Room Mates</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.realestate.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/real-estate.png') }}"
                                                            alt="pub_icon" class="" width="60">
                                                        <span class="d-block">Real Estate</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-free mx-3 mb-3">
                                                    <a href="{{ route('front.other.create_ad', 'create_free_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/others.png') }}" alt="pub_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Others</span>
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModalCenter_pre" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content m-t-124">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLongTitle">Select Premium ads Category</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-block home_small_icon">
                                        <ul class="list-inline">
                                            <div class="row">
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.national_autos.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/auto.png') }}"
                                                            alt="box_office_icon" class="" width="60">
                                                        <span class="d-block">Auto</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.babysitting.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/baby-sitting.png') }}"
                                                            alt="restaurants_icon" class="" width="60">
                                                        <span class="d-block">Baby Sitting</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.education.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/education.png') }}"
                                                            alt="temple_icon" class="" width="60">
                                                        <span class="d-block">Education & <br> Teaching</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.electronics.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/electronics.png') }}"
                                                            alt="pub_icon" class="" width="60">
                                                        <span class="d-block">Electronics</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.freestuff.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center" id="MenuButton"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/others.png') }}" alt="casinos_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Free Stuff</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.garagesale.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/gradge-sale.png') }}"
                                                            alt="restaurants_icon" class="" width="60">
                                                        <span class="d-block">Garage Sale</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.job.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/jobs.png') }}" alt="temple_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Jobs</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.desidate.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/desi-dates.png') }}" alt="pub_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Desi Meet</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.roommate.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/roommates.png') }}" alt="pub_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Room Mates</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.realestate.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/real-estate.png') }}"
                                                            alt="pub_icon" class="" width="60">
                                                        <span class="d-block">Real Estate</span>
                                                    </a>
                                                </li>
                                                <li class="list-inline-pre mx-3 mb-3">
                                                    <a href="{{ route('front.other.create_ad', 'create_premium_ad') }}"
                                                        onclick="return CheckLogin(this);"
                                                        class="text-capitalize text-dark text-center">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/others.png') }}" alt="pub_icon"
                                                            class="" width="60">
                                                        <span class="d-block">Others</span>
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="home-title">
                            <h2 class="d-inline-block ribbon">Movie Reviews</h2>
                        </div>
                        <div class="movie-cards d-flex align-items-initial">
                            <?php foreach ($movie_rating['lists'] as $key => $list) {
	?>
                            <div class="movie-card bg-white">
                                <div class="movie-body">
                                    <h4 class='h3 mb-0 text-black'>{{ $list->movie_name }} </h4>
                                    <?php
if (is_array($list->rating_data) || is_object($list->rating_data)) {
		$a = array_filter(array_column($list->rating_data, 0));
		$average = $a ? array_sum($a) / count($a) : 0;
		?>
                                    <div class="star_parent">
                                        <div class="Stars" style="--rating: {{ number_format((float) $average, 2) }};"
                                            aria-label="Rating of this product is 2.3 out of 5."></div>
                                    </div>

                                    <div class="movie-reviews">
                                        <?php foreach ($list->rating_data as $key => $value) {
			?>

                                        <?php if (isset($movie_rating['rating_source'][$key])) {
				if ($value[0] > 0) {?>
                                        <div class="d-flex justify-content-between mt-1">
                                            <a
                                                href="{{ $value[1] }}">{{ $movie_rating['rating_source'][$key]->source_name }}</a>
                                            <p class="text-dark">{{ $value[0] }}</p>
                                        </div>
                                        <?php }}?>
                                        <?php }?>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <a class="text-danger float-right ml-1" href="{{ route('front.moviereview.list') }}">View
                            More</a>
                    </div>
                </div>
                 <div class="col-lg-4 col-12 dmoviesandnational-api" style="padding-left: 4px;padding-right: 5px">
                <div class="loader"></div>
                </div>
            </div>
        </div>
        </div>
    </section>
<style>

    .nav-link-for-hompage{
        padding: 0.5rem 0.5rem;
    }
</style>



    <section class="section-padding">
        <div class="container-fluid">
            <div class="row">
                    <div class="px-lg-1 col-lg-4 col-md-6 col-sm-12 d-flex align-items-md-stretch">
                    <div class="col-12 border bg-white">
                        <h2 class="section-title training_heading_pla text-sm m-0 p-0 text-left  mt-5 mt-md-0">Training & Placement</h2>
                        <a href="{{ route('front.nationalbatch.create_ad') }}" class="btn btn-success ads_btn px-2 py-1"
                            onclick="return CheckLogin(this);">Create
                            post</a>
                        <div class="col-lg-12">
                            <ul class="nav nav-justified nav-pills" id="pills-tabContent" role="tablist" style="flex-wrap:nowrap;">
                                @foreach ($training_placement->category as $key => $cate)
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-for-hompage font-16 <?=$key == 0 ? 'active' : ''?>" data-toggle="pill"
                                            href="#pills-cat-<?=$cate->id?>" role="tab"
                                            aria-controls="ills-cate-<?=$cate->id?>"
                                            aria-selected="true"><?=$cate->name?></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="tab-content pb-3" id="pills-tabContent">
                            @foreach ($training_placement->category as $key => $cate)
                                <div class="tab-pane fade <?=$key == 0 ? 'show active' : ''?>"
                                    id="pills-cat-<?=$cate->id?>" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <?php if (count($training_placement->batches[$cate->id])) {?>
                                        <ul class="col-12 text-black_a">
                                            @foreach ($training_placement->batches[$cate->id] as $batch)
                                                <li>
                                                    <hr class="my-2">
                                                    <a href="{{ route('nationalbatch.view', $batch->slug) }}">
                                                        <span>{{ $batch->title }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="col-12 mt-3 text-right">
                                            <a href="{{ route('nationalbatch.index', base64_encode($cate->id)) }}">View
                                                More
                                                >></a>
                                        </div>
                                        <?php } else {?>
                                        <ul class="col-12 text-black_a">
                                            <li class="border-danger rounded border py-3 text-center">
                                                <p class="font-italic text-center">Data not found</p>
                                            </li>
                                        </ul>
                                        <?php }?>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                 </div>
                <div class="student_section px-lg-1 col-lg-4 col-md-6 col-sm-12 d-flex align-items-md-stretch">
                    <div class="col-12 border bg-white">
                        <h2 class="section-title mb-0 p-0  mt-5 mt-md-0">Student's Talk</h2>
                        <div class="col-lg-8 offset-lg-2">
                            <ul class="nav nav-justified nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link font-16 active" id="pills-home-tab" data-toggle="pill"
                                        href="#pills-accomodation" role="tab" aria-controls="pills-accomodation"
                                        aria-selected="true">Accomodation</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-16" id="pills-profile-tab" data-toggle="pill" href="#pills-campus"
                                        role="tab" aria-controls="pills-campus" aria-selected="false">Campus</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-16" id="pills-profile-tab" data-toggle="pill" href="#pills-other"
                                        role="tab" aria-controls="pills-other" aria-selected="false">Other</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content pb-3" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-accomodation" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <ul class="list-unstyled">
                                    <?php
if (count($student['accommodation'])) {
	foreach ($student['accommodation'] as $key => $value) {?>
                                    <li class="py-1">
                                        <a href="{{ route('studenttalk.view', ['slug' => $value->slug]) }}"
                                            class="href">
                                            <h3 class="font-weight-bold mb-0 text-black">{{ $value->title }}</h3>
                                            <p>{{ $value->u_name }} ->
                                                {{ $value->state_name }}
                                            </p>
                                        </a>
                                    </li>
                                    <?php }
} else {?>
                                    <ul class="col-12 text-black_a">
                                        <li class="border-danger rounded border py-3 text-center">
                                            <p class="font-italic text-center">Data not found</p>
                                        </li>
                                    </ul>
                                    <?php }?>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pills-campus" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <?php
if (count($student['campusJobs'])) {
	foreach ($student['campusJobs'] as $key => $value) {?>
                                <ul class="list-unstyled">
                                    <li class="py-1">
                                        <a href="{{ route('studenttalk.view', $value->slug) }}" class="href">
                                            <h3 class="font-weight-bold mb-0 text-black">{{ $value->title }}</h3>
                                            <p>{{ $value->u_name }} ->
                                                {{ $value->state_name }}
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                                <?php }
} else {?>
                                <ul class="col-12 text-black_a">
                                    <li class="border-danger rounded border py-3 text-center">
                                        <p class="font-italic text-center">Data not found</p>
                                    </li>
                                </ul>
                                <?php }?>
                            </div>
                            <div class="tab-pane fade" id="pills-other" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <?php
if (count($student['other'])) {
	foreach ($student['other'] as $key => $value) {?>
                                <ul class="list-unstyled">
                                    <li class="py-1">
                                        <a href="{{ route('studenttalk.view', $value->slug) }}" class="href">
                                            <h3 class="font-weight-bold mb-0 text-black">{{ $value->title }}</h3>
                                            <p>{{ $value->u_name }} ->
                                                {{ $value->state_name }}
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                                <?php }
} else {?>
                                <ul class="col-12 text-black_a">
                                    <li class="border-danger rounded border py-3 text-center">
                                        <p class="font-italic text-center">Data not found</p>
                                    </li>
                                </ul>
                                <?php }?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="px-lg-1 col-lg-4 col-md-6 col-sm-12 d-flex align-items-md-stretch">
                    <div class="col-12 border bg-white">
                        <h2 class="section-title mb-0 p-0">Forum</h2>
                        <div class="col-lg-8 offset-lg-2">
                            <ul class="nav nav-justified nav-pills" id="pills-tab" role="tablist">
                                <?php foreach ($forums as $key => $value) {?>
                                <li class="nav-item">
                                    <a class="nav-link font-16 <?=$key == 'latest' ? 'active' : ''?>"
                                        id="pills-{{ $key }}-tab" data-toggle="pill"
                                        href="#pills-{{ $key }}" role="tab"
                                        aria-controls="pills-{{ $key }}"
                                        aria-selected="true"><?=$key == 'latest' ? 'Rated' : 'Top viewed'?></a>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                        <div class="tab-content pb-3" id="pills-tabContent">
                            <?php foreach ($forums as $key => $value) {
	?>
                            <div class="tab-pane fade <?=$key == 'latest' ? 'show active' : ''?>"
                                id="pills-{{ $key }}" role="tabpanel"
                                aria-labelledby="pills-{{ $key }}-tab">
                                <?php
if (count($value)) {
		?>
                                <ul class="list-unstyled">
                                    <?php foreach ($value as $key => $forum) {?>
                                    <li class="py-1">
                                        <a href="{{ route('front.forum.view', $forum->slug) }}" class="href">
                                            <h3 class="font-weight-bold mb-0 text-black">{{ $forum->title }}</h3>
                                            <p>{{ $forum->parent_cat_name }} ->
                                                {{ $forum->cat_name }}</p>
                                        </a>
                                    </li>
                                    <?php }?>
                                </ul>
                                <?php
} else {?>
                                <ul class="col-12 text-black_a">
                                    <li class="border-danger rounded border py-3 text-center">
                                        <p class="font-italic text-center">Data not found</p>
                                    </li>
                                </ul>
                                <?php }?>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

        <section class="section-padding">
        <div class="container-fluid">
            <div class="row">


                <div class="col-lg-12 visting_sport_section d-flex align-items-md-stretch px-lg-1 vistingsports-api">
               <div class="loader"></div>
                </div>

            </div>
        </div>
    </section>


    <section id="blog" class="section-padding border-top border-bottom mt-2 bg-white">
        <div class="container">
            <h2 class="section-title mb-0 p-0">{{ $page_type == 'state' ? 'Grocery Store' : 'Blog Post' }}</h2>
            <div class="row">
                <div id="blog_carousal" class="owl-carousel owl-theme owl-loaded owl-drag">
                    @if ($page_type == 'state')
                        @foreach ($groceries_carousal as $list)
                            <div class="blog-item item">
                                <div class="blog-item-wrapper">
                                    <div class="blog-item-img">
                                        <a href="{{ route('front.grocieries.view', $list->slug) }}">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $list->image_url }}" alt="{{ $list->name }}"
                                                class="same_width_wrapper">
                                            <p class="blog_text">{{ $list->name }}

                                                     </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <?php foreach ($blog_carousal as $key => $list) {?>
                        <div class="blog-item item">
                            <div class="blog-item-wrapper">
                                <div class="blog-item-img">
                                    <a href="{{ route('front.blog.view', $list->Slug) }}">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{$list->image_url}}" alt="{{ $list->title }}"
                                            class="same_width_wrapper">
                                        <p class="blog_text">{{ $list->title }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section id="video_news" class="genral border-top border-bottom section-padding mt-2 bg-white">
        <div class="container">
            <h2 class="section-title mb-0 p-0">News Video</h2>
            <div class="row">
                <div id="video_carousal" class="owl-carousel owl-theme owl-loaded owl-drag">
                    <?php
                    // echo "<pre>";
                    // print_R($newsvideo_carousal );
                    //   echo "</pre>";
                    // $newsvideo_carousal = array();
                    foreach ($newsvideo_carousal as $key => $list) {?>
                    <div class="video-item item">
                        <div class="video-item-wrapper">
                            <div class="video-item-img">
                                <a href="{{ route('front.newsvideo.view', $list->slug) }}">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  
                                    src="{{ $list->youtube_thumb }}"  src1 ="{{ $list->youtube_thumb }}" alt="{{ $list->title }}">
                                    <p class="video_text">{{ $list->title }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                </div>

            </div>
    </section>



    <script type="text/javascript">
        $(".movie-cards").lightSlider({
            item: 5,
            responsive: [{
                    breakpoint: 1025,
                    settings: {
                        item: 3,
                        slideMove: 1,
                        slideMargin: 6,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        item: 2,
                        slideMove: 1
                    }
                }
            ]
        });

        $('.list-inline-free').click(function(e) {
            e.preventDefault();
            $('#exampleModalCenter_free').modal('hide');
        });


        $('.list-inline-pre').click(function(e) {
            e.preventDefault();
            $('#exampleModalCenter_pre').modal('hide');
        });
        /*$("#ad-slider").lightSlider({
            item: 10,
            autoWidth: false,
            responsive: [{
                    breakpoint: 1025,
                    settings: {
                        item: 10,
                        slideMove: 1,
                        slideMargin: 6,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        item: 5,
                        slideMove: 1
                    }
                }
            ]
        });*/


           recent();
        function recent(){

               $.ajax({
        url: "{{ route('home.recent') }}"  ,
        type: "POST",
        // dataType: "json",
        data: {
         c_id:$('.current_country_id').val(),
           s_code:$('.current_state').val(),
        },
        success: function(data) {
          //console.log(data);
          $('.recent-ads-api').html(data);
        }
      });


        }



           nritalk();
        function nritalk(){

               $.ajax({
        url: "{{ route('home.nristalk') }}"   ,
        type: "POST",
        // dataType: "json",
        data: {
          c_id:$('.current_country_id').val(),
           s_code:$('.current_state').val(),
        },
        success: function(data) {
          //console.log(data);
          $('.nris-ads-api').html(data);
        }
      });


        }



           dmoviesandnational();
        function dmoviesandnational(){

               $.ajax({
        url: "{{ route('home.dmoviesandnational') }}"   ,
        type: "POST",
        // dataType: "json",
        data: {
          c_id:$('.current_country_id').val(),
           s_code:$('.current_state').val(),
        },
        success: function(data) {
          //console.log(data);
          $('.dmoviesandnational-api').html(data);
        }
      });


        }


           vistingsports();
        function vistingsports(){

               $.ajax({
        url: "{{ route('home.vistingsports') }}"   ,
        type: "POST",
        // dataType: "json",
        data: {
          c_id:$('.current_country_id').val(),
           s_code:$('.current_state').val(),
        },
        success: function(data) {
          //console.log(data);
          $('.vistingsports-api').html(data);
        }
      });


        }
            <?php if (\Route::currentRouteName() == 'home' || \Route::currentRouteName() == 'home.gifdata') {?>

               gifdata();
        function gifdata(){

               $.ajax({
        url: "{{ route('home.gifdata') }}"   ,
        type: "POST",
        // dataType: "json",
        data: {
          c_id:$('.current_country_id').val(),
           s_code:$('.current_state').val(),
        },
        success: function(data) {
          //console.log(data);
          $('.gifdata-api').html(data);
        }
      });


        }


        <?php }?>




    </script>
@endsection
