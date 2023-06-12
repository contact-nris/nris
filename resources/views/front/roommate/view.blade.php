@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Room Mates</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('room_mate.index') }}">Room Mates /</a></li>
                            <li class="current">view</li>
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
                        <div id="roommate" class="owl-carousel owl-theme owl-loaded owl-drag">
                            @if ($roommate->Images)
                                @foreach ($roommate->Images as $img)
                                    <div class="item">
                                        <div class="product-img">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ $img }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="item">
                                    <div class="product-img">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid w-100" src="{{ asset('upload/commen_img/roommates.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="details-box bg-white">
                        <div class="ads-details-info">
                            <div class="details-meta">
                                <span><a href="#"><i class="fa fa fa-calendar"></i>
                                        {{ date_with_month($roommate->created_at) }}</a></span>
                                </a></span>
                                <span><a href="#"><i class="fa fa-map-marker"></i>
                                        {{ $roommate->city_id }}</a></span>
                                <span><a href="#"><i class="fa fa-eye"></i> {{ $roommate->total_views }}</a></span>
                            </div>
                            <div class="description mb-4">{!! $roommate->message !!}</div>
                            <h4 class="title-small mb-3">Specification:</h4>
                            <ul class="list-specification">
                                <div class="row pl-3">
                                    <li><i class="fa fa-user"></i><strong> Contact Name </strong>
                                        {{ $roommate->contact_name }}</li>
                                    <li><i class="fa fa-phone"></i><strong> Contact Number </strong>
                                        {{ $roommate->contact_number }}</li>
                                    <li><i class="fa fa-envelope"></i><strong> Contact Email </strong>
                                        {{ $roommate->contact_email }}</li>
                                    <li><i class="fa fa-dollar"></i><strong> Rent </strong>
                                        {{ amount($roommate->rent) }}</li>
                                    <li><i class="fa fa-crosshairs"></i><strong> Address </strong>
                                        {{ $roommate->address }}
                                    </li>
                                    <li><i class="fa fa-globe"></i><strong> Url </strong>
                                        <a href="{{ $roommate->url }}" target="_blank"> {{ $roommate->url }} </a>
                                    </li>
                                    <li><i class="fa fa-calendar"></i><strong>Ad Expiry Date</strong>
                                        {{ $roommate->end_date }}
                                    </li>
                                </div>
                            </ul>
                        </div>
                        <div class="tag-bottom">
                            <div class="float-left">
                                <ul class="advertisement_new">
                                    <li>
                                        <p><strong><i class="fa fa-folder-o"></i> Categories : </strong><a
                                                href='javascript:void(0)'>{{ $roommate->category_name_en }}</a>
                                        </p>
                                    </li>
                                    <li>
                                        <p><strong><i class="fa fa-user"></i> Gender : </strong><a
                                                href='javascript:void(0)'>
                                                <?php $gender_array = ['1' => 'Doesn\'t Matter', '2' => 'Male Only', '3' => 'Female Only'];?>
                                                {{ $gender_array[$roommate->gender_type] }}</a>
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
                                <div class="card-body">
                                    <h2>Comment</h2>

                                    <form action="{{ route('room_mate.submit') }}" method="post" id="form">
                                        @csrf
                                        <input type="hidden" name="model_id" value="{{ $roommate->id }}">
                                        <input type="hidden" name="current_url" value="{{ Request::url() }}">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="comment" placeholder="Message" class="form-control form-control-lg mt-3" rows="3"></textarea>
                                            </div>
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-common mt-3"
                                                    class="btn btn-red btn-lg mt-3 pl-5 pr-5">Post Comment
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    @include('layouts.bid', [
                                        'model_name' => 'RoomMate',
                                        'model_id' => $roommate->id,
                                    ])
                                    <hr class="m-0">
                                </div>
                                <div class="card-body py-0">
                                <h2 class="card-title m-0">Comments</h2>
                                    @include('layouts.comments', [
                                        'route' => 'room_mate.submit',
                                        'model_id' => $roommate->id,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                   <?php
$list = $roommate;
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
