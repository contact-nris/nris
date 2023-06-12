@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Real Estate</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('realestate.index') }}">Real Estate /</a></li>
                        <li class="current">{{$list->title}}</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-5 text-right">
                <a href="{{ route('front.realestate.create_ad','create_free_ad' ) }}" class="btn btn-success"
                    onclick="return CheckLogin(this);">Create Free Ad</a>
                <a href="{{ route('front.realestate.create_ad','create_premium_ad' ) }}" class="btn btn-warning"
                    onclick="return CheckLogin(this);">Create Premium Ad</a>
            </div>
        </div>
    </div>
</div>


<div class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="realestate" class="owl-carousel owl-theme owl-loaded owl-drag">
                    <?php if (!empty($list->images)) {
	foreach ($list->images as $key => $img) {?>
                    <div class="item">
                        <div class="product-img">
                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100 h-100" src="{{ $img }}" alt="">
                        </div>
                    </div>
                    <?php }
} else {?>
                    <div class="item">
                        <div class="product-img">
                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100 h-100" src="{{ asset('upload/commen_img/real-estate.png') }}" alt="">
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="product-info mt-3 row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="details-box bg-white">
                    <div class="ads-details-info">
                        <h2>{{$list->title}}</h2>
                        <div class="details-meta">
                            <span><a href="#"><i
                                        class="fa fa-calendar"></i>{{date("d M, h:i",strtotime($list->created_at))}}</a></span>
                            <span><a href="#"><i class="fa fa-eye"></i>{{$list->total_views}}</a></span>
                        </div>
                        <h4 class="title-small mb-3">Specification:</h4>
                        <ul class="list-specification">
                            <div class="row pl-3">

                                <li><i class="fa fa-calendar"></i><strong>Built Year </strong>{{$list->built_year}}</li>
                                <li><i class="fa fa-dollar"></i><strong>Property Price
                                    </strong>{{ amount($list->property_price) }}</li>
                                <li><i class="fa fa-square"></i><strong>Square Feet </strong>{{$list->square_feet}}</li>
                                <li><i class="fa fa-bed"></i><strong>Bedrooms </strong>{{$list->bedrooms}}</li>
                                <li><i class="fa fa-bath"></i></i><strong>Bathrooms </strong>{{$list->bathrooms}}</li>
                                <li><i class="fa fa-bed"></i><strong>Otherrooms </strong> {{$list->other}}</li>
                                <li><i class="fa fa-user"></i><strong>Contact Name </strong>{{$list->contact_name}}</li>
                                <li><i class="fa fa-phone"></i><strong>Contact Number </strong>{{$list->contact_name}}
                                </li>
                                <li><i class="fa fa-crosshairs"></i><strong>Address</strong>{{$list->address}}</li>
                                <li><i class="fa fa-globe"></i><strong>URL</strong><a href="{{$list->url}}" target="_blank">{{$list->url}}</a></li>
                                <li><i class="fa fa-envelope"></i><strong>Contact Email</strong>
                                    {{$list->contact_email}}
                                </li>
                                <li><i class="fa fa-calendar"></i><strong>Ad Expiry Date</strong> {{$list->end_date}}
                                </li>
                            </div>
                        </ul>
                        <div class="mb-4 description">
                            {{$list->message}}
                        </div>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement_new">
                                <li>
                                    <p><strong><i class="fa fa-folder-o"></i> Categories:</strong>
                                        <a
                                            href="{{ route('realestate.index', $list->category_slug) }}">{{$list->category_name}}</a>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="float-right">
                            <div class="share">
                                @include('layouts.share')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-3 comment-card">
                            <div class="card-body">
                                <h2>Comment</h2>

                                <form action="{{ route('realestate.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{$list->id}}">
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">

                                    <div class="row">
                                        <div class="col-12">
                                            <textarea name="comment" placeholder="Message"
                                                class="form-control form-control-lg mt-3" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-common mt-3"
                                                class="btn btn-red btn-lg mt-3 pl-5 pr-5">Post Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                @include('layouts.bid', [
                                    'model_name' => 'RealEstate',
                                    'model_id' => $list->id,
                                ])
                                <hr class="m-0">
                            </div>
                            <div class="card-body py-0">
                                <h2 class="card-title m-0">Comments</h2>
                                @include('layouts.comments',['route' => 'realestate.submit', 'model_id' => $list->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>






                        <?php

// $list->iframe = 1 ;
// $list->cat_name = 'Realestate';
// $list->city_name = $list->city_id;

// // print_r($list2);
// // exit;
// if(is_object($list2)){

//    if(isset($list2->slug)){
//      $list->slug2 =  $list2->slug;
//  }else{
//       $list->slug2 =  '';
//  }

//    if(isset($list2->view)){
//      $list->view2 =  $list2->view;
//  }else{
//       $list->view2 =  '';
//  }

//      $list->view =  'realestate.view';
//      $list->more_ads =1 ;
//      if(isset($list2->title)){
//      $list->more_ads_title = $list2->title;
//  }else{
//    $list->more_ads_title = ''
//  }
// }
?>
                 @include('layouts.add_post')



        </div>
    </div>
</div>



<script type="text/javascript">
$("#form").submit(function() {
    $this = $(this);
    $.ajax({
        url: $this.attr("action"),
        type: 'POST',
        dataType: 'json',
        data: new FormData($this[0]),
        processData: false,
        contentType: false,
        beforeSend: function() {
            $this.find(".btn-common").btn("loading");
        },
        complete: function() {
            $this.find(".btn-common").btn("reset");
        },
        success: function(json) {
            json_response(json, $this);
        },
    })

    return false;
})
</script>
@endsection