@extends('layouts.front', $meta_tags)

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">CarPool</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('addcarpool.form') }}">CarPool /</a></li>
                        <li class="current">Create CarPool</li>
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
                        <h3>Create CarPool</h3>
                    </div>
                    <form method="post" action="{{ route('addcarpool.submit_form', [$id]) }}" id="form">
                        <div class="card-body text-black create-ad">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-sm-4 form-group required">
                                    <label for="input-contact_name">Carpool Type</label>
                                    <select id="input-category_types" class="form-control" name="carpool_types">
                                        <option value="">Select CarPool Type</option>
                                        <option value="local">Local</option>
                                        <option value="interstate">Interstate</option>
                                        <option value="international">International</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-contact_name">Contact Name</label>
                                    <input type="text" class="form-control" name="contact_name" value="{{ auth()->user()->name }}" id="input-contact_name">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-contact_number">Contact Number</label>
                                    <input type="number" class="form-control" name="contact_number" id="input-contact_number">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-email">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly id="input-email" >
                                </div>

                                <div class="col-md-12 col-sm-4 form-group required">
                                    <label class="small">Journey Type</label>
                                    <select name="journeyType" id="journeyType" class="form-control input-sm">
                                        <option value="1">One Way</option>
                                        <option value="2">Two Way</option>
                                    </select>

                                </div>

                                <div class="col-md-6 form-group required">
                                    <label>From City</label>
                                    <select id="input-category_types" class="form-control" name="from_city">
                                        <option value="">Select From City</option>
                                        @foreach($cities as $key => $value)
                                            <option value="{{ $value->id }}">  {{ $value->state_code }} -> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group required">
                                    <label>To City</label>
                                    <select id="input-category_types" class="form-control" name="to_city">
                                        <option value="">Select To City</option>
                                        @foreach($cities as $key => $value)
                                            <option value="{{ $value->id }}"> {{ $value->state_code }} -> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group required">
                                    <label>From State</label>
                                    <select id="input-category_types" class="form-control" name="from_state">
                                        <option value="">Select From State</option>
                                        @foreach($states as $key => $value)
                                            <option value="{{ $value->code }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group required">
                                    <label>To State</label>
                                    <select id="input-category_types" class="form-control" name="to_state">
                                        <option value="">Select To State</option>
                                        @foreach($states as $key => $value)
                                            <option value="{{ $value->code }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group required">
                                    <label>From Country</label>
                                    <select id="input-category_types" class="form-control" name="from_country">
                                        <option value="">Select From Country</option>
                                        @foreach($country as $key => $value)
                                            <option value="{{ $value->code }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group required">
                                    <label>To Country</label>
                                    <select id="input-category_types" class="form-control" name="to_country">
                                        <option value="">Select To Country</option>
                                        @foreach($country as $key => $value)
                                            <option value="{{ $value->code }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="exampleFormControlTextarea1">Address</label>
                                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3" placeholder="Enter Address..."></textarea>
                                </div>

                                <div class="col-md-3 form-group required">
                                    <label for="input-city">Start Date</label>
                                    <input class="form-control" type="text" name="start_date" readonly="readonly" id="start_date">
                                </div>

                                <div class="col-md-3 form-group required">
                                    <label for="input-city">Start Time</label>
                                    <input class="form-control" type="text" name="start_time" readonly="readonly" id="start_time" >
                                </div>

                                <div class="col-md-3 form-group required end_date">
                                    <label for="input-city">End Date</label>
                                    <input class="form-control" type="text" name="end_date" readonly="readonly" id="end_date">
                                </div>

                                <div class="col-md-3 form-group required end_time">
                                    <label for="input-city">End Time</label>
                                    <input class="form-control" type="text" name="end_time" readonly="readonly" id="end_time">
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 form-group required">
                                            <label for="input-city">Flex Date</label>
                                            <div class="form-check d-flex align-items-end">
                                                <input class="form-check-input" type="radio" name="flex_date" id="flex_date_yes" value="yes" >
                                                <label class="form-check-label" for="flex_date_yes">Yes</label>
                                            </div>
                                            <div class="form-check d-flex align-items-end">
                                                <input class="form-check-input" type="radio" name="flex_date" id="flex_date_no" value="no" checked>
                                                <label class="form-check-label" for="flex_date_no">No</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group required">
                                            <label for="input-city">Flex Time</label>
                                            <div class="form-check d-flex align-items-end">
                                                <input class="form-check-input" type="radio" name="flex_time" id="flex_time_yes" value="Yes" >
                                                <label class="form-check-label" for="flex_time_yes">Yes</label>
                                            </div>
                                            <div class="form-check d-flex align-items-end">
                                                <input class="form-check-input" type="radio" name="flex_time" id="flex_time_no" value="No" checked>
                                                <label class="form-check-label" for="flex_time_no">No</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group required">
                                            <label for="input-city">Flex Location</label>
                                            <div class="form-check d-flex align-items-end">
                                                <input class="form-check-input" type="radio" name="flex_location" id="flex_location_yes" value="Yes" >
                                                <label class="form-check-label" for="flex_location_yes">Yes</label>
                                                <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                            </div>
                                            <div class="form-check d-flex align-items-end">
                                                <input class="form-check-input" type="radio" name="flex_location" id="flex_location_no" value="No" checked>
                                                <label class="form-check-label" for="flex_location_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">Save</button>
                            <a href="{{ route('addcarpool.form')}} " class="btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>

    $(document).ready(function () {
        apply_dp('#start_date');
        apply_dp('#end_date');
        start_time('start_time');
        start_time('end_time');
    });
    function start_time(id) {
        $('#' + id).timepicker({
            timeFormat: 'h:mm p',
            interval: 30,
            // minTime: '10',
            // maxTime: '6:00pm',
            // startTime: '12:00am',
            scrollbar: true
        });
    }

    if($('#journeyType').val() == 1){
        $('.end_date').addClass('d-none');
        $('.end_time').addClass('d-none');
    }
    $("#journeyType").change(function (e) {
        e.preventDefault();
        if($('#journeyType').val() == 2){
            $('.end_date').removeClass('d-none');
            $('.end_time').removeClass('d-none');
        } else {
            $('.end_date').addClass('d-none');
            $('.end_time').addClass('d-none');
        }
    });

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