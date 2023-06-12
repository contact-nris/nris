@extends('layouts.front',$meta_tags)

@section('content')
<style>
     @media screen and (max-width: 3000px) {
  .slick-list {
    height: 300px !important;
  }

}
 @media screen and (max-width: 1000px) {
  .slick-list {
    height: 50px !important;
  }

}
</style>
  <div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">


        <div class="py-1  m-t-124">
            <div class="row align-items-center justify-content-between mx-5 ">
                <div class="col-lg-3 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title text-nowrap" style="font-size: 27px;">Education &amp; Teaching</h2>
                        <!-- <ol class="breadcrumb">
                            <li><a href="http://127.0.0.1:8000/">Home /</a></li>
                            <li class="current">Education &amp; Teaching</li>
                        </ol> -->
                        <p><a href="https://www.nris.com/" class="text-white" style="font-size: 17px;">Home /</a>
                            <span style="font-size:17px ;color:var(--main-color)">Education &amp; Teaching</span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 text-center text-lg-right">
                    <a href="https://www.nris.com/education/create_free_ad" class="btn btn-success  my-1 py-1" onclick="return CheckLogin(this);">Create
                        Free Ad</a>
                    <a href="https://www.nris.com/education/create_premium_ad" class="btn btn-warning  my-1 py-1" onclick="return CheckLogin(this);">Create
                        Premium Ad</a>

                    <div class="col-lg-12 col-md-12 col-xs-12 page-content pl-1  pr-1">
                        <aside class="bg-white">
                            <div>
                                <form method="get" id="form_ajax" class="row">
                                    <div class="widget_search position-relative col-lg-3 col-md-3 col-xs-3">
                                        <input type="search" class="form-control" autocomplete="off" name="filter_name" placeholder="Search..." id="search-input" value="">
                                        <button type="button" id="search-submit" class="search-btn" fdprocessedid="crljqz9"><i class="fa fa-search"></i></button>
                                    </div>

                                    <div class=" col-lg-3 col-md-3 col-xs-3">
                                        <select name="category_type" class="form-control" fdprocessedid="d2728k">
                                            <option value="">Select Category</option>
                                            <option value="i-need-a-teacher">
                                                I need a Teacher </option>
                                            <option value="i-am-a-teacher">
                                                I am a Teacher </option>
                                            <option value="">
                                                science teacher </option>
                                            <option value="">
                                                music teacher </option>
                                            <option value="">
                                                English teacher </option>
                                            <option value="">
                                                social teacher </option>
                                            <option value="">
                                                sports trainer </option>
                                            <option value="">
                                                yoga teacher </option>
                                            <option value="">
                                                Hindi teacher </option>
                                            <option value="">
                                                Telugu teacher </option>
                                            <option value="">
                                                Dance teacher </option>
                                            <option value="">
                                                online courses </option>
                                            <option value="">
                                                analyst placements </option>
                                        </select>
                                    </div>

                                    <div class=" col-lg-3 col-md-3 col-xs-3">
                                        <select name="city_code" class="city_dropdown form-control w-100" fdprocessedid="tjp6e">
                                            <option value="">Select City</option>
                                            <option value="1">
                                                Hummelstown - Pennsylvania
                                            </option>
                                            <option value="2">
                                                Abbeville - Alabama
                                            </option>
                                            <option value="3">
                                                Abbeville - Georgia
                                            </option>
                                            <option value="4">
                                                Abbeville - Louisiana
                                            </option>
                                            <option value="5">
                                                Abbeville - Mississippi
                                            </option>
                                            <option value="6">
                                                Abbeville - SouthCarolina
                                            </option>
                                            <option value="7">
                                                Abbot - Maine
                                            </option>
                                            <option value="8">
                                                Abbotsford - Wisconsin
                                            </option>
                                            <option value="9">
                                                Abbott - Texas
                                            </option>
                                            <option value="10">
                                                Abbottstown - Pennsylvania
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-xs-3 text-center">
                                        <a href="https://www.nris.com/education-teaching" class="btn btn-secondary  my-1">Clear
                                            Filter</a>
                                        <button class="btn btn-common  my-1 " type="submit" id="button-filter" fdprocessedid="p92vd"><i class="fa fa-search"></i>Search</button>
                                    </div>
                                </form>
                            </div>
                        </aside>
                    </div>
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
                        <div CLASS=" d-none">
                        <form method="get" id="form_ajax" class="row" >
                            <div class="widget_search position-relative col-lg-3 col-md-3 col-xs-3" >
                                <input type="search" class="form-control" autocomplete="off" name="filter_name"
                                    placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                                <button type="button" id="search-submit" class="search-btn"><i
                                        class="fa fa-search"></i></button>
                            </div>

                            <div class=" col-lg-3 col-md-3 col-xs-3">
                                <select name="category_type" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php foreach ($category as $key => $t) {?>
                                        <option <?=slug($t->name) == $category_type ? 'selected' : ''?> value="<?=$t->slug?>">
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
                                    <a href="{{ route('educationteaching.index') }}"
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
                                                    <a href="{{ route('educationteaching.view', $list->slug) }}">
                                                        <?php if (!empty($list->images)) {?>
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid"
                                                            src="{{ array_values($list->images)[0] }}" alt="">
                                                        <?php } else {?>
                                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid"
                                                            src="{{ asset('upload/commen_img/education.png') }}" alt="">
                                                        <?php }?>
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
                                                            href="{{ route('educationteaching.view', $list->slug) }}">{{ $list->ShortTitle }}</a>
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

                    <div class="pagination-bar pagination justify-content-lg-center ">
                        {{ $lists->appends(request()->except('page'))->links('front.pagination') }}
                    </div>

                </div>
            </div>
        </div>
         @include('layouts.category_ver',$adv)

    </div>

    <script>
        $('#form_ajax').on('submit', function(e) {
            var url = "{{ route('educationteaching.index') }}";

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

      @include('layouts.category_hor',$adv)
  </div>
@endsection
