@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Desi Movies</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('desi_movies.index') }}">Desi Movies /</a></li>
                            <li class="current">{{ $desimovie->name }}</li>
                        </ol>
                    </div>
                </div>
                <!-- <div class="col-sm-5 text-right">
                    <a href="{{ route('front.babysitting.create_ad', 'create_free_ad') }}" class="btn btn-success py-1"
                        onclick="return CheckLogin(this);">Create Free Ad</a>
                    <a href="{{ route('front.babysitting.create_ad', 'create_premium_ad') }}" class="btn btn-warning py-1"
                        onclick="return CheckLogin(this);">Create Premium Ad</a>
                </div> -->
            </div>
        </div>
    </div>

    <div class="section-padding">
        <div class="container">
            <div class="product-info row">
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="ads-details-wrapper">

                        <!-- Multiple image carousal -->
                        <div id="babysitting">
                            <div class="item">
                                <div class="product-img">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100"
                                    src="{{ str_replace('upload/city_movies/' ,'upload/city_movies/', $desimovie->image_url) }}"
                                        alt="" a= "{{ $desimovie->image_url }}">
                                </div>
                            </div>
                        </div>
                        <!-- end -->

                        <div class="details-box bg-white">
                            <div class="ads-details-info">
                                <h2 class="mb-0">{{ $desimovie->name }}</h2>
                                <div class="details-meta">
                                    <span><i class="fa fa-calendar"></i>&nbsp;
                                        {{ date_with_month($desimovie->created_at) }}</span>&nbsp;
                                    <span><i class="fa fa-map-marker"></i>&nbsp; {{ $desimovie->city_name }}</span>&nbsp;
                                    <!-- <span><i class="fa fa-eye"></i>&nbsp; {{ $desimovie->total_views }}</span> -->
                                </div>

                                <!-- <h4 class="title-small mb-3">Contact:</h4> -->
                                <ul class="list-specification">
                                    <div class="row pl-3">
                                        <!-- <li><i class="fa fa-user"></i><strong> Name
                                            </strong>{{ $desimovie->contact_name }}
                                        </li> -->
                                        <!-- <li><i class="fa fa-phone"></i><strong> Call
                                            </strong>{{ $desimovie->contact_number }}
                                        </li> -->
                                        <li><i class="fa fa-envelope"></i><strong> URL </strong>
                                        <?php $a = "";?>
                                        <?php if ($desimovie->url !== "") {
	?>

                                        <a href='{{$desimovie->url}}' target='_blanl'>{{$desimovie->url}}</a>
                                        <?php
}?>
                                    </li>
                                        <li><i class="fa fa-calendar"></i><strong> Movie start Date </strong>
                                            @if($desimovie->sdate !== 0000-00-00 && $desimovie->edate !== "") {{  $desimovie->sdate  }} @else {{ $desimovie->sdate }} @endif
                                        </li>
                                        <li><i class="fa fa-calendar"></i><strong> Movie End Date </strong>
                                        @if($desimovie->edate !== 0000-00-00 && $desimovie->edate !== "") {{ $desimovie->edate }} @else {{ $desimovie->edate }} @endif
                                    </li>
                                </div>
                            </ul>
                            <h4 class="title-small mb-3">Message:</h4>

                                <div class="description mb-3">{!! $desimovie->description !!}</div>

                            </div>
                             <h4 class="title-small mb-3">Other Information:</h4>

                                <div class="description mb-3">{!! $desimovie->additional_info !!}</div>

                            </div>

                            <div class="tag-bottom">
                                <div class="float-left">
                                    <ul class="advertisement_new">
                                        <li>
                                            <!-- <p><strong><i class="fa fa-folder-o"></i> Categories : </strong>
                                                <a href='{{ route('front.babysitting.list', $desimovie->category_slug) }}'>{{ $desimovie->baby_sitting_name }}</a>
                                            </p> -->
                                        </li>
                                    </ul>
                                </div>
                                <div class="float-lg-right float-none">
                                    <div class="share">
                                        @include('layouts.share')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card comment-card mt-3">
                                    <div class="card-header">
                                        <h2 class="card-title m-0">Comments</h2>
                                    </div>
                                    <div class="card-body py-0">
                                        @include('layouts.comments', [
                                            'route' => 'desi_movie.submit',
                                            'model_id' => $desimovie->id,
                                        ])
                                    </div>

                                    <div class="card-body">
                                        <h2>Comment</h2>

                                        <form action="{{ route('desi_movie.submit') }}" method="post"
                                            id="form">
                                            @csrf
                                            <input type="hidden" name="model_id" value="{{ $desimovie->id }}">
                                            <input type="hidden" name="current_url" value="{{ Request::url() }}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <textarea name="comment" placeholder="Message" class="form-control form-control-lg mt-3" rows="3"></textarea>
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
                </div>


                   <?php

$list = $desimovie;
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
