@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Job</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('job.index') }}">Job /</a></li>
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
                    <form method="post" action="{{ route('front.job.submit_ad', [$ad_type,$id]) }}" enctype="multipart/form-data" id="form">
                        <div class="card-body text-black create-ad">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-title" class="control-label">Title</label>
                                    <input type=" title" class="form-control" id="input-title" name="title" value="{{ $ad->title }}" placeholder="Enter title here">
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
                                    <label for="input-category" class="control-label">Select Category</label>
                                    <select id="input-category" class="form-control" name="category">
                                        @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}" {{ $ad->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-job_role" class="control-label">Select Job role</label>
                                    <select id="input-job_role" class="form-control" name="job_role">
                                        <option value="">Select Job Role</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-employment_type" class="control-label">Employment Type</label>
                                    <select id="input-employment_type" class="form-control" name="employment_type">
                                        @php $employment_type = ['contracting','direct_employment']; @endphp
                                        @foreach($employment_type as $value)
                                            <option value="{{ $value }}" {{ $ad->emp_type == $value ? 'selected' : '' }}>{{ dashesToCamelCase($value, true) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-job_ref" class="control-label">Job Reference Id</label>
                                    <input type="text" class="form-control" name="job_ref_id" value="{{ $ad->job_ref_id }}" id="input-job_ref">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-url" class="control-label">URL</label>
                                    <input type="text" class="form-control" name="url" id="input-url" value="{{ $ad->url }}" >
                                    <span class="small-text">(eg: http://www.example.com)</span>
                                </div>

                                <div class="col-4"></div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-contact_name" class="control-label">Contact Name</label>
                                    <input type="text" class="form-control" name="contact_name" value="{{ $ad->contact_name ?: $user->first_name . ' ' . $user->last_name}}" id="input-contact_name">
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

                                <div class="col-md-12 col-sm-12 form-group form-check ml-2">
                                    <input id="input-use_address_on_map" type="checkbox" name="use_address_on_map" value="1" {{ $ad->use_address_on_map ? 'checked' : '' }}>
                                    <label for="input-use_address_on_map" class="form-check-label">Use this on map</label>
                                    <br>
                                    <a href="javascript:void(0)" id="share_location_btn" class="text-primary" onclick="getLocation()">Share Your Location</a>
                                    <span id="location_addr"></span>
                                    <span class="hide" id="share_location_cancel_btn"><a href=""></a></a></span>
                                    <input type="hidden" name="address" id="address" value="">
                                </div>

                                <!-- state -->
                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-state" class="control-label">State</label>
                                     <select id="input-state" class="form-control" name="states_details">
                                        @foreach($states_select as $key => $value)
                                        <option value="{{ $key }}" {{ strtolower($ad->states_details) == strtolower($key) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                                                        <br>
                                    <label>Selected States </label><br>
                                    <input type="text"  class="form-control" readonly name="state_id" id="state_id" value="{{ $current_state }}" />
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-city" class="control-label">City</label>
                                    <input type="text" id="city" autocomplete="off" value="{{ $city_name }}"  class="form-control input-sm" />
                                    <input type="hidden" name="city_id" id="city_id" value="{{ $ad->city }}" class="required" />

                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-city" class="control-label">Ad Expiry Date</label>
                                    <input class="form-control" type="text" name="expiry_date" readonly="readonly"  value="{{ format_dp($ad->end_date ?: '', 'front') }}" id="expiry_date">
                                    <input type="hidden" name="ad_type" value="{{ $ad_type }}">
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">{{ $ad_type_text=='Create Premium Ad' ? 'Go to payment' : "Save Ad" }}</button>
                            <a href="{{ route('job.index')}} " class="btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.state')
@php
    $images_ = [];
    foreach ($ad->images as $key => $image) {
        $images_[] =  [
        'id' => $key,
        'src' => "{$image}",
        ];
    }
    $images_ = json_encode($images_, true);
@endphp
<script>
    apply_dp('#expiry_date');
    apply_dp('#input-next_date');

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
        var job_roles = @json($job_roles);
        var selected_job_role_id = $("#input-category").val();
        var selected_job = '{{ $ad->job_role }}';


        var optarray = job_roles.map(function(k, j) {
            return {
                "value": k.job_cat_id,
                "option": "<option value='" + k.id + "'>" + k.role + "</option>"
            }
        })

        $("#input-category").on('change', function() {
            $("#input-job_role").children('option').remove();
            var addoptarr = [];
            for (i = 0; i < optarray.length; i++) {
                if (optarray[i].value == $(this).val()) {
                    addoptarr.push(optarray[i].option);
                }
            }
            $("#input-job_role").html(addoptarr.join(''))
        }).change();

        if(selected_job) {
            $("#input-job_role").val(selected_job);
        }
    })

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

                if (json['errors']['state_id'] && ($ele2 = $container.find('#input-state'))) {
                    $ele2.addClass('is-invalid');
                    $ele2.parents(".form-group").addClass("has-error");
                }
            },
        })

        return false;
    })
</script>
@endsection