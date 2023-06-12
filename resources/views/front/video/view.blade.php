@extends('layouts.front')

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">{{ $news_video->video_link }}</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">News {{ $news_video->video_link }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">

    <div class="container">
        <!--<div class="row">-->
        <!--    <div class="col-lg-12 col-md-12 col-xs-12 mb-3">-->
        <!--        <h1 class="widget-title mb-3">{{ $news_video->title }}</h1>-->
        <!--        <iframe src="{{ $news_video->video_link }}" width="100%" height="350" frameborder="0"></iframe>-->
        <!--    </div>-->
        <!--</div>-->



<!--<object data='{{ $news_video->video_link }}?autoplay=1' width='560px' height='315px'>-->
    







        <div>
            <div class="page-content">
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="list-view" class="tab-pane fade active show">
                            <div class="row">
                                <div class="col-12">
                                    <h1>More News</h1>
                                </div>
                                <?php foreach ($more_videos as $key => $list) {?>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="featured-box">
                                            <figure class="w-100">
                                                <div class="black_section">
                                                    <h4 class='text-white'>{{ $list->title }}</h4>
                                                </div>
                                                <a href="{{route('front.video.view', $list->meta_title .'-'.$list->id) }}"><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $list->youtube_thumb }}" alt=""></a>
                                            </figure>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .black_section {
        background: #000;
        padding: 10px;
        color: #fff;
        position: absolute;
        top: 75%;
        left: 0;
        width: 100%;
        height: 25%;
        opacity: 0.7;
    }
</style>
@endsection