@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Student's Talk</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('adduniversity.index') }}">Student's Talk /</a></li>
                        <li class="current">{{ $student->title }}</li>
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
                <div class="details-box mt-0 bg-white">
                    <div class="ads-details-info">
                        <h2>{{ $student->title }}</h2>
                        <div class="details-meta">
                            <span><a href="#"><i class="fa fa-calendar"></i>
                                    {{ date_with_month($student->created_at) }}</a></span>
                            </a></span>
                            <span><a href="#"><i class="fa fa-user"></i>
                                    {{ $student->user }}</a></span>
                            </a></span>
                            <!-- <span><a href="javascript:void(0)"><i class="fa fa-eye"></i> {{$student->total_views}}</a></span> -->
                            <!-- <span><a href="javascript:void(0)"><i class="fa fa-list"></i> {{$student->sub_cate}}</a></span> -->
                        </div>

                        <div class="mb-4 description">{!! $student->message !!}</div>
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
                                @include('layouts.comments',['route' => 'front.studenttalk.submit', 'model_id' =>
                                $student->id])
                            </div>
                            <div class="card-body">
                                <h2>Add a comment</h2>

                                <form action="{{ route('front.studenttalk.submit') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="model_id" value="{{$student->id}}">
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

$list = $student;
$list->more_ads = 1;

?>
                    @include('layouts.add_post')
        </div>
    </div>

</div>
<script type="text/javascript">
$("#form").submit(function() {
    $this = $(this);
    $.ajax({
        url: $this.attr("action") + "?slug=" + "{{ $student->slug }}",
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