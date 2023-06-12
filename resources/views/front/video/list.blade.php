@extends('layouts.front', $meta_tags)

@section('content')
    <style type="text/css">
        #list-view .featured-box.movie-box figure.w-100 {
            height: auto;
        }

        #list-view .featured-box.movie-box figure.w-100 img {
            height: auto;
        }

        #list-view .featured-box.movie-box figure.w-100 .black_section {
            position: unset;
        }

        #list-view .featured-box.movie-box figure.w-100 .black_section a.btn img {
            width: 24px;
            height: 23px;
        }

        #list-view .featured-box.movie-box figure.w-100 .black_section a.btn {
            line-height: 1;
        }

        #list-view .featured-box.movie-box figure.w-100 .black_section h4 {
            margin: 0;
        }
    </style>






    <div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Videos</h2>

                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a>
                            <span
                                style="font-size:17px ;color:var(--main-color)">Videos</span>
                                 </p>
                    </div>

                </div>

            </div>
            </div>
            </div>



    <div class="section-padding">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 page-sidebar mt-3">
                    @if ($lang_slug)
                        <div class="card">
                            <div class="card-body">
                                @if ($header_thumb)
                                    <div class="col-12">
                                        <figure class="position-relative video_figgure">
                                            <div class="black_section justify-content-between align-items-lg-center">
                                                <div class="align-items-center row">
                                                    <div class="col-12">
                                                        <div class="text-group text-center movie_day_info">
                                                            <h1 class='text-white m-0'>Movie of the day</h1>
                                                            <h1 class='d-inline m-0 text-white'>{{ $header_thumb->title }} ({{ $header_thumb->language_name }})</h1>
                                                            <span class='h2 d-block text-white'>{{ date("d-m-Y") }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="" style="position: absolute;right: 11px;">
                                                        @include('layouts.list_like', [
                                                            'display' => 'd-inline-flex p-0',
                                                            'model' => 'video',
                                                            'model_id' => $header_thumb->id,
                                                            'like_count' => count($header_thumb->video_like),
                                                            'dislike_count' => count($header_thumb->video_dislike),
                                                            'user_like_status' => $header_thumb->like_status,
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="various fancybox" href="{{ $header_thumb->videourl }}">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="video_bg_cover" src="{{ $header_thumb->youtube_thumb }}"
                                                    alt="{{ $header_thumb->title }}">
                                            </a>
                                        </figure>
                                    </div>
                                @endif
                                <h3 class="pl-3">All Categories</h3>
                                <ul class="category_icon text-center text-black">
                                    <?php foreach ($categories as $key => $category) {?>
                                    <li class="">
                                        <a
                                            href="{{ route('front.videos.category', [$lang_slug, $category->category_name]) }}">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid rounded-circle" src="{{ $category->small_image }}"
                                                alt="{{ $category->category_name }}">
                                        </a>
                                        <span class='d-block text-center'>{{ $category->category_name }}</span>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="search-bar col-12 my-1 px-0">
                        <div class="search-inner border-dark border">
                            <form class="search-form" method="get">
                                <div class="form-group inputwithicon w-100">
                                    <input type="search" class="form-control" autocomplete="off" name="filter_name"
                                        placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                                </div>
                                <button class="btn btn-common" type="submit" id="button-filter"><i
                                        class="fa fa-search"></i>
                                    Search Now</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 page-content">
                    <div class="adds-wrapper">
                        <div class="tab-content">

                            <div id="list-view" class="tab-pane fade active show">
                                @if (count($lists))
                                          <div class="row">
                                        <?php foreach ($lists as $key => $list) {?>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="featured-box movie-box">
                                                <figure class="w-100" k = "{{$list->id}}">
                                                    <!--fancybox-->
                                                    <a class="various h-100 " target="_blank"

                                            href="{{ $list->videourl }}"><img
                                                            class="img-fluid w-100"
                                                            src="https://img.youtube.com/vi/{{ $list->video_id }}/0.jpg"
                                                            alt="{{ $list->title }}"></a>
                                                    <div class="black_section">
                                                        <h4 class='responsive_text text-white'>{{ $list->title }}</h4>
                                                        <div>
                                                            @include('layouts.list_like', [
                                                                'model' => 'video',
                                                                'model_id' => $list->id,
                                                                'like_count' => count($list->video_like),
                                                                'dislike_count' => count($list->video_dislike),
                                                                'user_like_status' => $list->like_status,
                                                            ])
                                                        </div>
                                                    </div>
                                                </figure>
                                            </div>
                                        </div>
                                        <?php }?>

                                    </div>
                                @else
                                    <div class="alert alert-info w-100 mt-3">
                                        <h4>No Data Found! Try Different Search</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>



   <!--<object data='https://www.youtube.com/embed/nfk6sCzRTbM?autoplay=1' width='560px' height='315px'>-->




                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".various").fancybox({
                type: "iframe", //<--added
                maxWidth: 600,
                maxHeight: 400,
                fitToView: false,
                width: 800,
                height: 600,
                autoSize: false,
                closeClick: true,
                closeBtn: true,
                openEffect: 'none',
                closeEffect: 'none',
            });
        })
    </script>
    <style>
        @media(min-width: 768px) and (max-width:991px) {
            .search-bar .btn-common {
                position: absolute;
                right: 5px;
                width: 157px;
            }

            .responsive_text {
                height: 16px;
                overflow: hidden;
            }
        }
    </style>
@endsection
