@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Room mate</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('room_mate.index') }}">Room mate /</a></li>
                        <li class="current">{{ $ad_type_text }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding mt-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $ad_type_text }}</h3>
                    </div>
                    <form method="post" action="{{ route('front.roommate.submit_ad', [$ad_type, $id]) }}" enctype="multipart/form-data" id="form">
                        <div class="card-body text-black create-ad">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-title" class="control-label">Title</label>
                                    <input type="text" class="form-control" id="input-title" name="title" value="{{ $ad->title }}" placeholder="Enter title here">
                                    <span class="form-text text-muted">Only alphabets, numbers and spaces are allowed</span>
                                </div>

                                <div class="col-md-12 col-sm-12 form-group">
                                    <label for="input-image" class="control-label">Image</label>
                                    <div class="input-images"></div>
                                    <div class="form-text text-muted">
                                        <ul>
                                        <li class="text-danger font-weight-bold">Allowed JPG, PNG. Max file size 200KB.</li>
                                                <li class="text-danger font-weight-bold">If your upload image is larger than 200KB allowed,  reduce the size of the image if you want to reduce the size of the image click this link  <a href="https://picresize.com/"
                                                        target="_blank"
                                                        class="red_mark text-capitalize text-muted">&nbsp;<u>Click
                                                            here to
                                                            convert</u></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-description" class="control-label">Description</label>
                                    <textarea class="form-control" id="input-description" name="description" rows="3" placeholder="Enter description here">{{ $ad->message }}</textarea>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-category" class="control-label">Type</label>
                                    <select id="input-category" class="form-control" name="category">
                                        @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}" {{ $ad->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-gender_type" class="control-label">Gender Preference</label>
                                    <select id="input-gender_type" class="form-control" name="gender_type">
                                        <option value="">Select Type</option>
                                        @php $gender_type = ['1'=> 'Doesn\'t Matter','2'=>'Male Only','3' => 'Female Only']; @endphp
                                        @foreach($gender_type as $key => $value)
                                            <option value="{{ $key }}" {{ $ad->gender_type == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="rent" class="control-label">Rent</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="rent"><i class="fa fa-dollar"></i></span>
                                        </div>
                                        <input class="form-control w-75" type="text" value="{{ $ad->rent }}" name="rent" aria-describedby="rent">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-contact_name" class="control-label">Contact Name</label>
                                    <input type="text" class="form-control" name="contact_name" value="{{$ad->contact_name ?: $user->first_name . ' ' . $user->last_name}}" id="input-contact_name">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-contact_number" class="control-label">Contact Number</label>
                                    <input type="number" class="form-control" name="contact_number" value="{{ $ad->contact_number ?: $user->mobile }}" id="input-contact_number">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-email" class="control-label d-inline-flex">
                                        <span>Email</span>
                                        <div class="form-check-inline pl-2">
                                           <input class="form-check-input" type="checkbox" name="show_email" id="show_email" value="1" {{ $ad->show_email ? 'checked' : '' }}>
                                            <label class="cursor-pointer form-check-label" for="show_email">Show Email</label>
                                        </div>
                                    </label>
                                    <input type="text" class="form-control" name="email" id="input-email" value="{{ $ad->contact_email ?: $user->email }}">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-url" class="control-label">URL</label>
                                    <input type="text" class="form-control" name="url" value="{{ $ad->url }}" id=" input-url">
                                    <span class="small-text">(eg: http://www.example.com)</span>
                                </div>

                                <div class="col-md-12 col-sm-12 form-group form-check ml-2">
                                    <input id="input-use_address_on_map" type="checkbox" name="use_address_on_map" value="1" {{ $ad->use_address_on_map ? 'checked' : '' }}>
                                    <label for="input-use_address_on_map" class="form-check-label">Use this on map</label>
                                    <br>
                                    <a href="javascript:void(0)" id="share_location_btn" class="text-primary" onclick="getLocation()">Share Your Location</a>
                                    <span id="location_addr"></span>
                                    <span class="hide" id="share_location_cancel_btn"><a href=""></a></a></span>
                                    <input type="hidden" name="address" id="address" value="">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-city" class="control-label">City</label>
                                    <input type="text" id="city" autocomplete="off" value="{{ $city_name }}"  class="form-control input-sm" />
                                    <input type="hidden" name="city_id" id="city_id" value="{{ $ad->city }}" class="required" />
                                    <br>
                                    <label>Selected States </label><br>
                                    <input type="text"  class="form-control" readonly name="state_id" id="state_id" value="{{ $current_state }}" />

                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-city" class="control-label">Ad Expiry Date</label>
                                    <input class="form-control" type="text" name="expiry_date" id="expiry_date" readonly="readonly" value="{{ format_dp($ad->end_date ?: '', 'front') }}">
                                    <input type="hidden" name="ad_type" value="{{ $ad_type }}">
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">{{ $ad_type_text=='Create Premium Ad' ? 'Go to payment' : "Save Ad" }}</button>
                            <a href="{{ route('room_mate.index')}} " class="btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$images_ = [];
foreach ($ad->images as $key => $image) {
	$images_[] = [
		'id' => $key,
		'src' => "{$image}",
	];
}
$images_ = json_encode($images_, true);
?>

<script>
    apply_dp('#expiry_date');

    $("#city").autocomplete({
        source: function(request, response) {
            $.getJSON("{{ route('city.autocomplete') }}", {
                state_code: $("#state_id").val(),
                term: request.term
            }, response);
        },
        select: function(event, uic) {
            event.preventDefault();
            $("#city").val(uic.item.label);
            $('#city_id').val(uic.item.value);
        }
    });

    $(function() {
        $('.input-images').imageUploader({
            extensions: ['.jpg', '.jpeg', '.png'],
            mimes: ['image/jpeg', 'image/png', 'image/gif'],
            maxSize: 200 * 1024,
            imagesInputName: 'images',
            preloadedInputName: 'old',
            preloaded: {!! $ad->images ? $images_ : '[]' !!},
        });
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        $.get(
            'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + position.coords.latitude + ',' + position.coords.longitude,
        function (data) {
            if (data.status == 'OK') {
                $("#location_addr").html(data.results[0].formatted_address);
                $("#share_location_cancel_btn").removeClass('hide');
                $("#share_location_btn").addClass('hide');
                $("#address").val(data.results[0].formatted_address);
            } else {
                $("#location_addr").html("Unable to find your address");
            }
        },
        'json'
        );
    }

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

                $ele = $this.find('.input-images');
                $ele.removeClass('border border-danger');
                $error = false;

                $.each(Object.keys(json.errors), function(key, value) {
                    if (value.includes('image')) {
                        $error = true;
                        $ele.after("<span class='text-danger alert-dismissable d-block'>" + json.errors[value] + "</span>");
                    }
                });

                if ($error) {
                    $ele.addClass('border border-danger');
                    $ele.parents(".form-group").addClass("has-error");
                }

                if (json['errors']['city_id'] && ($ele1 = $container.find('#city'))) {
                    $ele1.addClass('is-invalid');
                    $ele1.parents(".form-group").addClass("has-error");
                }
            },
        })

        return false;
    })
</script>

@endsection