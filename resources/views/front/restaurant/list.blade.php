@extends('layouts.front', $meta_tags)
@section('content')
    <!--<div class="page-header" style="background: url(assets/img/banner1.jpg);">-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-3 py-2">-->
    <!--                <div class="breadcrumb-wrapper">-->
    <!--                    <h2 class="product-title">Restaurants</h2>-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        <li><a href="{{ route('home') }}">Home /</a></li>-->
    <!--                        <li class="current"><?=isset($demo) ? $demo->type . ' Restaurants' : 'Restaurants'?>-->
    <!--                        </li>-->
    <!--                    </ol>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-md-9">-->
    <!--                @include('front.business_item', ['place_name' => $page_type])-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->



<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Temples</h2>

                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a>
                            <span
                                style="font-size:17px ;color:var(--main-color)"><?=isset($demo) ? $demo->type . ' Restaurants' : 'Restaurants'?></span>
                                 </p>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 text-center text-lg-right">
                     @include('front.business_item', ['place_name' => $page_type])
                </div>
            </div>
            </div>
            </div>



    <div class="section-padding">
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-12 col-md-12 p-0">
                    <div class="search-bar mt-0">
                        <div class="search-inner">
                            <form class="search-form" method="get">
                                <div class="form-group inputwithicon">
                                    <i class="fa fa-search"></i>
                                    <input type="search" class="form-control" autocomplete="off" name="filter_name"
                                        placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                                </div>
                                <div class="form-group inputwithicon">
                                    <div class="pt-2">
                                        <select name="city_code" class="city_dropdown form-control w-100">
                                            <option value="">Select City</option>
                                            <?php foreach ($cities as $key => $city) {?>
                                            <option <?=$city->id == old_get('city_code') ? 'selected' : ''?>
                                                value="<?=$city->id?>">
                                                {{ $city->name }}
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-common" type="submit" id="button-filter"><i
                                        class="fa fa-search"></i>
                                    Search Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 page-content">
                    <div class="adds-wrapper">
                        <div class="tab-content">
                            <div id="list-view" class="tab-pane fade active show">
                                @if (count($lists))
                                    <div class="row">
                                        <?php foreach ($lists as $key => $list) {
	?>
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-xl-2 p-0">
                                            <div class="featured-box">
                                                <figure>
                                                    <a href="{{ route('restaurants.view', $list->slug) }}">
                                                        @if (empty($list->image_url))
                                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100"
                                                                src="https://www.nris.com/stuff/images/home_logo_icon.png"
                                                                alt="">
                                                        @else
                                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" src="{{ $list->image_url }}"
                                                                alt="">
                                                        @endif
                                                    </a>
                                                </figure>
                                                <?php
$hour = App\BusinessHour::where(['model' => 'f_restaurant', 'model_id' => $list->id])
		->get()
		->first();
	if ($hour) {
		$time_array = $hour->toArray();
		$var = date('H:i');
		$today = strtolower(date('D'));
		$today_date = date('Y-m-d');

		$current_time_open = $time_array[$today . '_open'] ? date('Y-m-d\TH:i:s.000', strtotime("$today_date" . $time_array[$today . '_open'])) : false;
		$current_time_close = $time_array[$today . '_close'] ? date('Y-m-d\TH:i:s.000', strtotime("$today_date" . $time_array[$today . '_close'])) : false;
	}
	?>
                                                @if ($hour && $hour->is24 == '1')
                                                    <span class="bg-success position-absolute p-2 text-white"
                                                        style="top:15px;right:1px;">24/7 Open</span>
                                                @elseif($hour && $hour->is24 == '0')
                                                    <span data-time _open="<?=$current_time_open?>"
                                                        close="<?=$current_time_close?>"
                                                        class="position-absolute p-2 text-white"
                                                        style="top:15px;right:1px;"></span>
                                                @endif

                                                <div class="feature-content">
                                                    <div class="product">
                                                        <a href="#">{{ $list->category_name_en }} </a>
                                                    </div>
                                                    <h4><a
                                                            href="{{ route('restaurants.view', $list->slug) }}">{{ $list->ShortTitle }}</a>
                                                    </h4>
                                                    <div class="listing-bottom">
                                                        <div class="d-flex justify-content-between">
                                                            <div>CITY : {{ $list->city_name }}</div>
                                                            <div class="mr-2 text-center"><i class="fa fa-eye"></i>
                                                                <div>{{ $list->total_views }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                @else
                                    <div class="alert alert-info mt-3">
                                        <h4>No results found! Try Different Search</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pagination-bar pagination justify-content-center">
                        {{ $lists->appends(request()->except('page'))->links('front.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
