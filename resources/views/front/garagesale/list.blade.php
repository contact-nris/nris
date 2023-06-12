@extends('layouts.front',$meta_tags)

@section('content')




<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Garage Sale</h2>

                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a>
                            <span
                                style="font-size:17px ;color:var(--main-color)">Garage Sale</span>
                                 </p>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 text-center text-lg-right">
                    <a href="{{ route('front.garagesale.create_ad','create_free_ad' ) }}"
                        class="btn btn-success col-lg-6 col-md-4 my-1 py-1" onclick="return CheckLogin(this);">Create
                        Free Ad</a>
                    <a href="{{ route('front.garagesale.create_ad','create_premium_ad' ) }}"
                        class="btn btn-warning col-lg-6 col-md-4 my-1 py-1" onclick="return CheckLogin(this);">Create
                        Premium Ad</a>
                </div>
            </div>
            </div>
            </div>

        @include('layouts.category_hor',$adv)

  <div class="section-padding row mx-0 ">
        <div class="col-lg-10 col-md-12 col-12" style="width:85%;display:inline-block;">
    <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 page-content pl-1  pr-1">
                    <aside class="bg-white">
                        <div>
                        <form method="get" id="form_ajax" class="row" >
                            <div class="widget_search  position-relative col-lg-3 col-md-3 col-xs-3" >
                                <input type="search" class="form-control" autocomplete="off" name="filter_name"
                                    placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                                <button type="button" id="search-submit" class="search-btn"><i
                                        class="fa fa-search"></i></button>
                            </div>

                            <div class=" col-lg-3 col-md-3 col-xs-3">
                                <select name="category_type" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php foreach ($category as $key => $t) {?>
                                        <option <?=slug($t->slug) == $category_type ? 'selected' : ''?> value="<?=$t->slug?>">
                                            <?=$t->name?>
                                        </option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class=" col-lg-3 col-md-3 col-xs-3">
                                <select name="city_code" class="city_dropdown form-control w-100">
                                    <option value="">Select City</option>
                                    <?php foreach ($cities as $key => $city) {?>
                                        <option <?=$city->id == old_get('city_code') ? 'selected' : ''?> value="<?=$city->id?>">
                                            {{ $city->name }}
                                        </option>
                                    <?php }?>
                                </select>
                            </div>


                                 <div class="col-lg-3 col-md-3 col-xs-3 text-center">
                                <a href="{{ route('garagesale.index') }}"
                                        class="btn btn-secondary col-lg col-11 my-1">Clear
                                        Filter</a>
                                    <button class="btn btn-common col-lg my-1 col-11" type="submit"
                                        id="button-filter"><i class="fa fa-search"></i>Search</button>
                                </div>


                        </form>
                        </div>
                    </aside>
                </div>

                <div class="col-lg-12 col-md-12 col-xs-12 page-content">
                    <div class="adds-wrapper">
                        <div class="tab-content">
                            <div id="list-view" class="tab-pane fade active p-2 show">
                                @if (count($lists))
                                    <div class="row">
                                        <?php foreach ($lists as $key => $list) {?>
                                          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pl-1 pr-1">
                                            <div class="featured-box">
                                                <figure class="update position-relative">
                                                    <a href="{{ route('garagesale.view', $list->slug) }}">
                                                        <?php if (!empty($list->images)) {?>
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid"
                                                            src="{{ array_values($list->images)[0] }}" alt="">
                                                        <?php } else {?> <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid"
                                                            src="{{ asset('upload/commen_img/gradge-sale.png') }}" alt=""> <?php }?>
                                                    </a>
                                                    @if ($list->images)
                                                        <div class="small_image">
                                                            @foreach ($list->images as $image)
                                                                <div class="item">
                                                                    <a target="_blank" class="fancybox" rel="{{ $list->title }}"
                                                                        href="{{ $image }}">
                                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" width="50"
                                                                            src="{{ $image }}"
                                                                            alt="{{ $list->title }}">
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </figure>

                                                <div class="feature-content update">
                                                    <div class="product">
                                                        <a href="javascript:void(0)">{{ $list->category_name }}</a>
                                                    </div>
                                                    <h4><a
                                                            href="{{ route('garagesale.view', $list->slug) }}">{{ $list->title }}</a>
                                                    </h4>
                                                    <div class="dsc">{{ $list->short_desc }}</div>
                                                    {{-- <div class="specification">
                                                        <ul class="list-specification">
                                                            <div class="row pl-3">
                                                                <li><i class="fa fa-taxi"></i><strong> Model
                                                                    </strong>{{ $list->model_name }}</li>
                                                                <li><i class="fa fa-calendar"></i><strong>Model Year
                                                                    </strong>{{ $list->year }}</li>
                                                                <li><i class="fa fa-dollar"></i><strong>Price
                                                                    </strong>{{ amount($list->price) }}</li>
                                                                <li><i class="fa fa-paint-brush"></i><strong>Color
                                                                    </strong>{{ $list->color_name }}</li>
                                                                <li><i class="fa fa-car"></i><strong>Transmission </strong>{{ $list->transmission }}</li>
                                                            </div>
                                                        </ul>
                                                    </div> --}}

                                                    <div class="listing-bottom">
                                                        <div class="d-flex justify-content-between">
                                                            <div>City : {{ $list->city_name }}</div>
                                                            <div>View : {{ $list->total_views }}</div>
                                                            <div>Post Date : {{ date_full($list->created_at) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                @else
                                    <div class="alert alert-info mt-3">
                                        <h4>No Data Found! Try Different Search</h4>
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
    @include('layouts.category_ver',$adv)
</div>
<script>
    $('#form_ajax').on('submit', function(e) {
        var url = "{{ route('garagesale.index') }}";

        var category_type = $('select[name=\'category_type\']').val();
        if (category_type != '') {
            url += '/' + encodeURIComponent(category_type);
        }

        var filter_name = $('input[name=\'filter_name\']').val();
        if (filter_name) {
            url += '?filter_name=' + encodeURIComponent(filter_name);
        }

        var city_code = $('select[name=\'city_code\']').val();
        if (city_code != '') {
            url.includes('filter_name') ? url += '&city_code=' + encodeURIComponent(city_code) : url += '?city_code=' + encodeURIComponent(city_code);
        }
        location = url;
        e.preventDefault();
    });
</script>
@endsection