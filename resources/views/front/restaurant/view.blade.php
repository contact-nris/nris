@extends('layouts.front', $meta_tags)

@section('content')
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title"> Restaurants</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('restaurants.index') }}"> Restaurants /</a></li>
                            <li class="current">{{ $list->name }}</li>
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
                        <div id="restaurants" class="owl-carousel owl-theme owl-loaded owl-drag">
                            <div class="item">
                                <div class="product-img">
                                    <a href="#">
                                        @if (empty($list->image_url))
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100"
                                                src="http://www.nris.com/stuff/images/home_logo_icon.png" alt="">
                                        @else
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $list->image_url }}" alt="">
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="details-box bg-white">
                        <div class="ads-details-info">
                            <h2>{{ $list->name }}</h2>
                            <div class="details-meta">
                                <span><a href="#"><i
                                            class="fa fa-calendar"></i>{{ date('d M, h:i', strtotime($list->created_at)) }}</a></span>
                                <span><a href="#"><i class="fa fa-map-marker"></i>{{ $list->city_name }}</a></span>
                                <span><a href="#"><i class="fa fa-eye"></i>{{ $list->total_views }}</a></span>
                            </div>
                            <h4 class="title-small mb-3">Specification:</h4>
                            <ul class="list-specification">
                                <li><i class="fa fa-globe"></i><strong>Url </strong>
                                    <a href="{{ $list->url }}" target="_blank">{{ $list->url }}</a>
                                </li>
                                <li><i class="fa fa-envelope"></i><strong>Email </strong>
                                    {{ $list->email_id }}
                                </li>
                                <li><i class="fa fa-phone"></i><strong>Contact Number </strong>
                                    {{ $list->contact }}
                                </li>
                                <li><i class="fa fa-crosshairs"></i><strong>Address </strong>{{ $list->address }}</li>
                            </ul>
                            <div class="mb-4">
                                {{ $list->message }}
                            </div>
                        </div>
                        <div class="tag-bottom">
                            <div class="float-left">
                                <ul class="advertisement_new">
                                    <li>
                                        <p><strong><i class="fa fa-folder-o"></i> Category : </strong>
                                            {{ $list->category_name_en }}
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
                                    @include('layouts.comments', ['route' => 'restaurants.submit', 'model_id' => $list->id])
                                </div>
                                <div class="card-body">
                                    <h2>Add a comment</h2>

                                    <form action="{{ route('restaurants.submit') }}" method="post" id="form">
                                        @csrf
                                        <input type="hidden" name="model_id" value="{{ $list->id }}">
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
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <aside class="details-sidebar">
                        <div class="widget card">
                            <h4 class="widget-title card-header">Map Container</h4>
                            <div class="agent-inner card-body">
                                <div class="map-container mt-3 p-0">
                                    <?php
if ($list['address'] != '') {
	$address = $list['address'];
} else {
	$address = $list['city'] . ', United States';
}
?>

                                    <iframe width="100%" height="250" frameborder="0" style="border:0"
                                        src="https://www.google.com/maps/embed/v1/place?key=<?=config('app.map_key')?>&q=<?=urlencode($address)?>"
                                        allowfullscreen>
                                    </iframe>
                                    <div id="business-hours">
                                        @include('layouts.business_hour', ['model' => 'f_restaurant', 'model_id' => (int) $list->id])
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
