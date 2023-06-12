@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">National Auto</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('auto.index') }}">National Auto /</a></li>
                        <li class="current">{{ $list->title }}</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-5 text-right">
                <a href="{{ route('front.national_autos.create_ad', 'create_free_ad') }}" class="btn btn-success py-1" onclick="return CheckLogin(this);">Create Free Ad</a>
                <a href="{{ route('front.national_autos.create_ad', 'create_premium_ad') }}" class="btn btn-warning py-1" onclick="return CheckLogin(this);">Create Premium Ad</a>
            </div>
        </div>
    </div>
</div>

 <!--$list_box['data'] = array( -->
 <!--'name' => 'National Auto' , -->
 <!--'href' => "{{ route('auto.index') }}" ,-->
 <!--'ad1'=> "{{ route('front.national_autos.create_ad', 'create_free_ad') }}", -->
 <!--'ad2'=> "{{ route('front.national_autos.create_ad', 'create_premium_ad') }}", -->
 <!--'create' => 1  ,-->
 <!--'type' =>'big',-->
 <!--'title' => $list->title -->
 <!--);-->

 <!--include('layouts.listbox')-->

<div class="section-padding">
    <div class="container">
        <div class="product-info row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="ads-details-wrapper">
                    <div id="auto" class="owl-carousel owl-theme owl-loaded owl-drag">
                        <?php if (!empty($list->images)) {?>
                            @foreach ($list->images as $image)
                            <div class="item">
                                <div class="product-img">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $image }}" alt="">
                                </div>
                            </div>
                            @endforeach
                        <? } else { ?>
                            <div class="item">
                                <div class="product-img">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ asset('upload/commen_img/auto.png') }}" alt="">
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="details-box bg-white">
                    <div class="ads-details-info">
                        <h2>{{ $list->title }}</h2>
                        <div class="details-meta">
                            <span><a href="#">
                                    <i class="fa fa-calendar"></i>{{ date('d M, h:i', strtotime($list->created_at)) }}</a></span>
                            <span><a href="#"><i class="fa fa-map-marker"></i>{{ $list->city_name }}</a></span>
                            <span><a href="#"><i class="fa fa-eye"></i>{{ $list->total_views }}</a></span>
                        </div>
                        <h4 class="title-small mb-3">Specification:</h4>
                        <ul class="list-specification">
                            <div class="row pl-3">
                                <li><i class="fa fa-calendar"></i><strong>Model Year </strong>{{ $list->year }}</li>
                                <li><i class="fa fa-dollar"></i><strong>Price </strong>{{ amount($list->price) }}
                                </li>
                                <li><i class="fa fa-taxi"></i><strong> Model </strong>{{ $list->model_name }}
                                </li>
                                <li><i class="fa fa-car"></i><strong>Transmission
                                    </strong>{{ $list->transmission }}</li>
                                <li><i class="fa fa-tag"></i><strong>Type </strong>{{ $list->type }}</li>
                                <li><i class="fa fa-car"></i><strong>Cylinder </strong>{{ $list->cylinder }}
                                </li>
                                <li><i class="fa fa-user-o"></i><strong>Drive Train
                                    </strong>{{ $list->drive_train }}</li>

                                <li><i class="fa fa-paint-brush"></i><strong>Color </strong>{{ $list->color_name }}
                                </li>
                                <li><i class="fa fa-address-card"></i><strong>VIN Number
                                    </strong>{{ $list->vin_number }}</li>
                                <li><i class="fa fa-road"></i><strong>ODO Meter Reading
                                    </strong>{{ $list->odo }}</li>
                                <li><i class="fa fa-tachometer"></i><strong>Milage </strong>{{ $list->mpg }}</li>
                                <li><i class="fa fa-user"></i><strong>Contact Name
                                    </strong>{{ $list->contact_name }}</li>
                                <li><i class="fa fa-phone"></i><strong>Contact Number
                                    </strong>{{ $list->contact_number }}</li>
                                <!--<li><i class="fa fa-crosshairs"></i></i><strong>Address</strong>{{ $list->address }}-->
                                </li>
                                <li><i class="fa fa-envelope"></i><strong>Email</strong> {{ $list->contact_email }}
                                </li>
                                <li><i class="fa fa-globe"></i><strong>url</strong> <a target="_blank" href="{{ $list->url }}">{{ $list->url }}</a></li>
                                <li><i class="fa fa-calendar"></i><strong>Ad Expiry Date</strong>
                                    {{ $list->end_date }}
                                </li>
                            </div>
                        </ul>
                        <div class="description mb-4">
                            {{ $list->message }}
                        </div>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement_new">
                                <li>
                                    <p><strong><i class="fa fa-archive"></i> Condition :
                                        </strong>{{ $list->auto_condition }}</p>
                                </li>
                                <li>
                                    <p><strong><i class="fa fa-car"></i> Make : </strong> <a href="#">{{ $list->auto_makes_name }}</a></p>
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
                        <div class="card comment-card mt-3">
                            <div class="card-body">
                                <h2 class="m-0">Comment</h2>
                                <form action="{{ route('auto.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{ $list->id }}">
                                    <input type="hidden" name="current_url" value="{{ Request::url() }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <textarea name="comment" placeholder="Message" class="form-control form-control-lg mt-3" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-common mt-3" class="btn btn-red btn-lg mt-3 pl-5 pr-5">Post Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                @include('layouts.bid', [
                                    'model_name' => 'AutoClassified',
                                    'model_id' => $list->id,
                                ])
                                <hr class="m-0">
                            </div>
                            <div class="card-body py-0">
                                <h2 class="card-title m-0">Comments</h2>
                                @include('layouts.comments', ['route' => 'auto.submit', 'model_id' => $list->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <?php

// $list->iframe = 1 ;
// $list->cat_name = 'Auto';
// $list->city_name = $list->city_id;
// if(is_object($list2)){
//      $list->slug =  $list2->slug;
//      $list->view =  'auto.view';
//      $list->more_ads =1 ;
//      $list->more_ads_title = $list2->title;
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