@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Desi Meet</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('front.desi_date') }}">Desi Meet /</a></li>
                        <li class="current">{{ $desi->title }}</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-5 text-right">
                <a href="{{ route('front.desidate.create_ad','create_free_ad' ) }}" class="btn btn-success" onclick="return CheckLogin(this);">Create Free Ad</a>
                <a href="{{ route('front.desidate.create_ad','create_premium_ad' ) }}" class="btn btn-warning" onclick="return CheckLogin(this);">Create Premium Ad</a>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">

    <div class="container">

        <div class="product-info row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div id="desidate" class="owl-carousel owl-theme owl-loaded owl-drag">
                    @if(!empty($desi->images))
                    <?php foreach ($desi->images as $key => $img) {?>
                        <div class="item">
                            <div class="product-img">
                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $img }}" alt="">
                            </div>
                        </div>
                    <?php }?>
                    @else
                        <div class="item">
                            <div class="product-img">
                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ asset('upload/commen_img/desi-dates.png') }}" alt="">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="details-box bg-white">
                    <div class="ads-details-info">
                        <h2>{{ $desi->title }}</h2>
                        <div class="details-meta">
                            <span><i class="fa fa-calendar"></i> {{ date_with_month($desi->created_at) }}</span>&nbsp;
                            <span><i class="fa fa-map-marker"></i> {{$desi->city_id}}</span>&nbsp;
                            <span><i class="fa fa-eye"></i> {{$desi->total_views}}</span>
                        </div>
                        <div class="mb-4 description">{!! $desi->details !!}</div>

                        <ul class="list-specification">
                            <div class="raw pl-2">
                                <li><i class="fa fa-phone"></i><strong>Contact Number : </strong>{{$desi->contact}}</li>
                                <li><i class="fa fa-crosshairs"></i><strong>Address : </strong> {{$desi->address}}</li>
                                <li><i class="fa fa-envelope"></i><strong>Email : </strong> {{$desi->email}}</li>
                                <li><i class="fa fa-globe"></i><strong>Url : </strong> <a href="{{$desi->url}}" target="_blank"> {{$desi->url}} </a></li>
                            </div>
                        </ul>
                        <p class="mb-4 description">
                            {{$desi->other_details}}
                        </p>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement_new">
                                <li>
                                    <p><strong><i class="fa fa-folder-o"></i> Categories : </strong><a href='javascript:void(0)'>{{ $desi->category_name_en }}</a>
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
                                @include('layouts.comments',['route' => 'front.desi_date.submit', 'model_id' => $desi->id])
                            </div>
                            <div class="card-body">
                                <h2>Comment</h2>

                                <form action="{{ route('front.desi_date.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{$desi->id}}">
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">
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
                        <!-- @include('layouts.bid', [
                            'model_name' => 'MyPartner',
                            'model_id' => $desi->id,
                        ]) -->
                    </div>
                </div>
            </div>



                   <?php
$list = $desi;
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