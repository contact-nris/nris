@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Free Stuff</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('freestuff.index') }}">Free Stuff /</a></li>
                        <li class="current">{{ $freestuff->title }}</li>
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
                    <div id="freestuff" class="owl-carousel owl-theme owl-loaded owl-drag">
                        @if(!empty($freestuff->Images))
                        <?php foreach ($freestuff->Images as $key => $img) {?>
                        <div class="item">
                            <div class="product-img">
                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $img }}" alt="">
                            </div>
                        </div>
                        <?php }?>
                        @else
                        <div class="item">
                            <div class="product-img">
                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ asset('upload/commen_img/free-stuff.jpg') }}" alt="">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="details-box bg-white">
                    <div class="ads-details-info">
                        <h2>{{ $freestuff->title }}</h2>
                        <div class="details-meta">
                            <span><a href="#"><i class="fa fa-calendar"></i>
                                    {{ date_with_month($freestuff->created_at) }}</a></span>
                            </a></span>
                            <span><a href="#"><i class="fa fa-map-marker"></i> {{$freestuff->city_id}}</a></span>
                            <span><a href="#"><i class="fa fa-eye"></i> {{$freestuff->total_views}}</a></span>
                        </div>
                        <div class="mb-4 description">{!! $freestuff->message !!}</div>
                        <h4 class="title-small mb-3">Specification:</h4>
                        <ul class="list-specification">
                            <div class="row pl-3">
                                <li><i class="fa fa-user"></i><strong> Contact Name </strong>
                                    {{$freestuff->contact_name}}</li>
                                <li><i class="fa fa-phone"></i><strong> Contact Number </strong>
                                    {{$freestuff->contact_number}}</li>
                                <li><i class="fa fa-crosshairs"></i><strong> Address </strong> {{$freestuff->address}}
                                </li>
                                <li><i class="fa fa-globe"></i><strong> Url </strong><a href="{{$freestuff->url}}" target="_blank"> {{$freestuff->url}} </a></li>
                                <li><i class="fa fa-calendar"></i><strong>Ad Expiry Date</strong>
                                    {{$freestuff->end_date}}
                                </li>
                            </div>
                        </ul>
                    </div>
                    <div class="tag-bottom">
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
                                @include('layouts.comments',['route' => 'freestuff.submit', 'model_id' =>
                                $freestuff->id])
                            </div>
                            <div class="card-body">
                                <h2>Comment</h2>

                                <form action="{{ route('freestuff.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{$freestuff->id}}">
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <textarea name="comment" placeholder="Message"
                                                class="form-control form-control-lg mt-3" rows="3"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-common mt-3"
                                                class="btn btn-red btn-lg mt-3 pl-5 pr-5">Post Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

                   <?php
$list = $freestuff;
$list->iframe = 1;

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