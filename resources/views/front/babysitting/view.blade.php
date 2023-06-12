@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Baby Sitting</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('front.babysitting.list') }}">Baby Sitting /</a></li>
                            <li class="current">{{ $babysitting->title }}</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-5 text-right">
                    <a href="{{ route('front.babysitting.create_ad', 'create_free_ad') }}" class="btn btn-success py-1"
                        onclick="return CheckLogin(this);">Create Free Ad</a>
                    <a href="{{ route('front.babysitting.create_ad', 'create_premium_ad') }}" class="btn btn-warning py-1"
                        onclick="return CheckLogin(this);">Create Premium Ad</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section-padding">
        <div class="container">
            <div class="product-info row">
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="ads-details-wrapper">

                        <!-- Multiple image carousal -->
                        <div id="babysitting" class="owl-carousel owl-theme owl-loaded owl-drag">
                            @if (!empty($babysitting->Images))
                                @foreach ($babysitting->Images as $img)
                                    <div class="item">
                                        <div class="product-img">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $img }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="item">
                                    <div class="product-img">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ asset('upload/commen_img/baby_sitting.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- end -->

                        <div class="details-box bg-white">
                            <div class="ads-details-info">
                                <h2 class="mb-0">{{ $babysitting->title }}</h2>
                                <div class="details-meta">
                                    <span><i class="fa fa-calendar"></i>&nbsp;
                                        {{ date_with_month($babysitting->created_at) }}</span>&nbsp;
                                    <span><i class="fa fa-map-marker"></i>&nbsp; {{ $babysitting->city_name }}</span>&nbsp;
                                    <span><i class="fa fa-eye"></i>&nbsp; {{ $babysitting->total_views }}</span>
                                </div>
                                <h4 class="title-small mb-3">Message:</h4>
                                <div class="description mb-3">{!! $babysitting->message !!}</div>

                                <h4 class="title-small mb-3">Contact:</h4>
                                <ul class="list-specification">
                                    <div class="row pl-3">
                                        <li><i class="fa fa-user"></i><strong> Name
                                            </strong>{{ $babysitting->contact_name }}
                                        </li>
                                        <li><i class="fa fa-phone"></i><strong> Call
                                            </strong>{{ $babysitting->contact_number }}
                                        </li>
                                        <li><i class="fa fa-envelope"></i><strong> Email </strong>
                                            {{ $babysitting->contact_email }}
                                        </li>
                                        <li><i class="fa fa-calendar"></i><strong> Ad Expiry Date </strong>
                                            {{ $babysitting->end_date }}
                                        </li>
                                    </div>
                                </ul>

                            </div>
                            <div class="tag-bottom">
                                <div class="float-left">
                                    <ul class="advertisement_new">
                                        <li>
                                            <p><strong><i class="fa fa-folder-o"></i> Categories : </strong>
                                                <a
                                                    href='{{ route('front.babysitting.list', $babysitting->category_slug) }}'>{{ $babysitting->baby_sitting_name }}</a>
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
                                <div class="card comment-card mt-3">
                                    <div class="card-header">
                                        <h2 class="card-title m-0">Comments</h2>
                                    </div>
                                    <div class="card-body py-0">
                                        @include('layouts.comments', [
                                            'route' => 'front.babysitting.submit',
                                            'model_id' => $babysitting->id,
                                        ])
                                    </div>

                                    <div class="card-body">
                                        <h2>Comment</h2>

                                        <form action="{{ route('front.babysitting.submit') }}" method="post"
                                            id="form">
                                            @csrf
                                            <input type="hidden" name="model_id" value="{{ $babysitting->id }}">
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

$list = $babysitting;
$list->new_form = 1;
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
