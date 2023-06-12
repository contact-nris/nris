@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Desi Page</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Desi Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">

    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="search-bar">
                    <div class="search-inner">
                        <form class="search-form" method="get">
                            <div class="form-group inputwithicon">
                                <i class="fa fa-search"></i>
                                <input type="search" class="form-control" autocomplete="off" name="filter_name" placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                            </div>
                            <div class="form-group inputwithicon">
                                <div class="pt-2">
                                    <select name="city_code" class="city_dropdown form-control w-100">
                                        <option value="">Select City</option>
                                        <?php foreach ($cities as $key => $city) {?>
                                            <option <?=$city->id == old_get('city_code') ? 'selected' : ''?> value="<?=$city->id?>">
                                                {{ $city->name }}
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-common" type="submit" id="button-filter"><i class="fa fa-search"></i>
                                Search Now</button>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12 col-xs-12 page-content">
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="list-view" class="tab-pane fade active show">
                            <div class="row">
                                <?php foreach ($lists as $key => $list) {?>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="featured-box">
                                            <figure>
                                                <a href="{{ route('desi_page.view', $list->slug) }}">
                                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid " src="{{ $list->image_url }}"  src1="{{ $list->image_url }}" alt="">
                                                </a>
                                            </figure>
                                            <div class="feature-content">
                                                <div class="product">{{$list->category_name_en}}</div>
                                                <h4>
                                                    <a href="{{ route('desi_page.view', $list->slug) }}">{{ $list->ShortTitle }}</a>
                                                </h4>
                                                <div class="listing-bottom">
                                                    <div class="d-flex justify-content-between">
                                                        <div>City: {{ $list->city_name }}</div>
                                                        <div>Views: {{ $list->total_views }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
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