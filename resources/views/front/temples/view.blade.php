@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Temples</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('front.temples') }}">Temples /</a></li>
                        <li class="current">{{ $temple->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">

    <div class="container">

        <div class="product-info row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="ads-details-wrapper">
                    <div id="temple" class="owl-carousel owl-theme owl-loaded owl-drag">
                        <div class="item">
                            <div class="product-img">
                            @if($temple->image_url)
                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $temple->image_url }}" src1="{{ $temple->image_url }}" alt="">
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details-box bg-white">
                    <div class="ads-details-info">
                        <h2>{{ $temple->name }}</h2>
                        <div class="details-meta">
                            <span><a href="#"><i class="fa fa-calendar"></i>
                                    {{ date_with_month($temple->created_at) }}</a></span>
                            </a></span>
                            <span><a href="javascript:void(0)"><i class="fa fa-map-marker"></i>{{$temple->city_name}}</a></span>
                            <span><a href="javascript:void(0)"><i class="fa fa-eye"></i>
                                    {{$temple->total_views}}</a></span>
                        </div>
                        <h4 class="title-small mb-3">Extra Details:</h4>
                        <ul class="list-specification">
                            <li><i class="fa fa-phone"></i><strong> Contact Number </strong>{{$temple->contact}}</li>
                            <li><i class="fa fa-crosshairs"></i><strong> Address </strong> {!! $temple->address !!}
                            </li>
                            <li><i class="fa fa-envelope"></i><strong> Email </strong> {{$temple->email_id}}</li>
                            <li><i class="fa fa-globe"></i><strong> Url </strong><a target="_blank" href="{{$temple->url}}" style="line-break:anywhere">{{$temple->url}}</a></li>
                        </ul>
                        <p class="mb-4">
                            {!! $temple->other_details !!}
                        </p>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement_new">
                                <li>
                                    <p><strong><i class="fa fa-folder-o"></i> Temples Type Name : </strong><a href='javascript:void(0)'>{{ $temple->temples_type_name }}</a>
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
                            <div class="card-header">
                                <h2 class="card-title m-0">Comments</h2>
                            </div>
                            <div class="card-body py-0">
                                @include('layouts.comments',['route' => 'front.temples.comment.submit', 'model_id' => $temple->id])
                            </div>
                            <div class="card-body">
                                <h2>Respond to Ad</h2>

                                <form action="{{ route('front.temples.comment.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{$temple->id}}">
                                    <div class="row">
                                        <div class="col-12">
                                            <textarea name="comment" placeholder="Message" class="form-control form-control-lg mt-3" rows="3"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-common mt-3" class="btn btn-red btn-lg mt-3 pl-5 pr-5">Post Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
                <aside class="details-sidebar">
                    <div class="widget card">
                        <h4 class="widget-title card-header">Map Container</h4>
                        <div class="agent-inner card-body">
                            <div class="map-container p-0 mt-3 ">
                                <?php
if ($temple['address'] != "") {
	$address = $temple['address'];
} else {
	$address = $temple['city'] . ', United States';
}
?>

                                <iframe width="100%" height="250" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?=config('app.map_key')?>&q=<?=urlencode($address)?>" allowfullscreen>
                                </iframe>

                                <div id="business-hours">
                                    @include('layouts.business_hour',array('model' => 'f_temple', 'model_id' => (int)$temple->id ))
                                </div>

                            </div>
                        </div>
                    </div>

                </aside>
            </div>
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
</script>
@endsection