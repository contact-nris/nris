@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Casinos</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('casinos.index') }}">Casinos /</a></li>
                        <li class="current">{{$list->name}}</li>
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
                    <div id="casinos" class="owl-carousel owl-theme owl-loaded owl-drag">
                        <div class="item">
                            <div class="product-img">
                                <a href="#">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $list->image_url }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details-box bg-white">
                    <div class="ads-details-info">
                        <h2>{{$list->name}}</h2>
                        <div class="details-meta">
                            <span><a href="#"><i class="fa fa-calendar"></i>{{date("d M, h:i",strtotime($list->created_at))}}</a></span>
                            <span><a href="#"><i class="fa fa-map-marker"></i>{{$list->city_name}}</a></span>
                            <span><a href="#"><i class="fa fa-eye"></i>{{$list->total_views}}</a></span>
                        </div>
                        <h4 class="title-small mb-3">Specification:</h4>
                        <ul class="list-specification">
                            <div class="row pl-3">
                                <li><i class="fa fa-globe"></i><strong>Url </strong> <a href="{{$list->url}}" target="_blank">{{$list->url}}</a> </li>
                                <li><i class="fa fa-comments"></i><strong> Comment </strong>
                                <li><i class="fa fa-phone"></i><strong>Contact Number </strong>{{$list->contact}}</li>
                                <li><i class="fa fa-crosshairs"></i><strong>Address </strong>{{$list->address}}</li>
                            </div>
                        </ul>
                        <div class="mb-4">
                            {{$list->message}}
                        </div>
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
                                @include('layouts.comments',['route' => 'casinos.submit', 'model_id' =>
                                $list->id])
                            </div>
                            <div class="card-body">
                                <h2>Add a comment</h2>

                                <form action="{{ route('casinos.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{$list->id}}">
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
                    </div>
                </div>

            </div>


            <?php
$list->iframe = 1;
$list->hours = 1;
$list->add_model = 'f_casinos';
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

    $("#formBio").submit(function() {
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