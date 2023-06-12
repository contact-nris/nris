@extends('layouts.front', $meta_tags)

@section('content')
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">National Auto</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('auto.index') }}">National Auto /</a></li>
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
                        <form method="post" action="{{ route('front.national_autos.submit_ad', [$ad_type, $id]) }}"
                            enctype="multipart/form-data" id="form">
                            <div class="card-body create-ad text-black">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 form-group required">
                                        <label for="input-title" class="control-label">Title</label>
                                        <input type="text" class="form-control" id="input-title" name="title"
                                            value="{{ $ad->title }}" placeholder="Enter title here">
                                        <span class="form-text text-muted">Only alphabets, numbers and spaces are
                                            allowed</span>
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
                                        <textarea class="form-control" id="input-description" name="description" rows="3"
                                            placeholder="Enter description here">{{ $ad->message }}</textarea>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-auto_makes" class="control-label">Select Make</label>
                                        <select id="input-auto_makes" class="form-control" name="auto_makes">
                                            <option value="" class="select_make">Select Make</option>
                                            @foreach ($auto_makes as $key => $auto)
                                                <option value="{{ $auto->id }}"
                                                    {{ $ad->make == $auto->id ? 'selected' : '' }}>{{ $auto->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-auto_models" class="control-label">Select Auto Models</label>
                                        <select id="input-auto_models" class="form-control" name="auto_models">
                                            <option value="">Select motors</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-auto_colors">Select Color <span id="auto_color" class="d-none"></span></label>

                                        <select id="input-auto_colors" class="form-control" name="auto_colors">
                                            <option value="">Select Color</option>
                                            @foreach ($auto_colors as $key => $auto)
                                                <option value="{{ $auto->id }}" data-color="{{ $auto->code }}"
                                                    {{ $ad->color == $auto->id ? 'selected' : '' }}>{{ $auto->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-condition" class="control-label">Select Condition</label>
                                        <select id="input-condition" class="form-control" name="condition">
                                            <option value="">Select Condition</option>
                                            @foreach ($auto_properties['condition'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ $ad->auto_condition == $value ? 'selected' : '' }}>
                                                    {{ dashesToCamelCase($value, true) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-transmission" class="control-label">Select Transmission</label>
                                        <select id="input-transmission" class="form-control" name="transmission">
                                            <option value="">Select Transmission</option>
                                            @php $transmission = ['automatic','manual']; @endphp
                                            @foreach ($auto_properties['transmission'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ $ad->transmission == $value ? 'selected' : '' }}>
                                                    {{ ucfirst($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-cylinder" class="control-label">Select cylinder</label>
                                        <select id="input-cylinder" class="form-control" name="cylinder">
                                            <option value="">Select Cylinder</option>
                                            @foreach ($auto_properties['cylinder'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ $ad->cylinder == $value ? 'selected' : '' }}>
                                                    {{ ucfirst($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-type" class="control-label">Select Auto Type</label>
                                        <select id="input-type" class="form-control" name="type">
                                            <option value="">Select Type</option>
                                            @foreach ($auto_properties['type'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ $ad->type == $value ? 'selected' : '' }}>
                                                    {{ dashesToCamelCase($value, true) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-drive_train" class="control-label">Select Drive Train</label>
                                        <select id="input-drive_train" class="form-control" name="drive_train">
                                            <option value="">Select Drive Train</option>
                                            @foreach ($auto_properties['drive_train'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ $ad->drive_train == $value ? 'selected' : '' }}>
                                                    {{ dashesToCamelCase($value, true) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-year" class="control-label">Select Year</label>
                                        <select id="input-year" class="form-control" name="year">
                                            <option value="">Select Year</option>
                                            <?php for ($i = (int) date("Y"); $i >= 1955; $i--) {?>
                                            <option value="<?=$i?>" {{ $ad->year == $i ? 'selected' : '' }}><?=$i?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-vin_number" class="control-label">Vin Number</label>
                                        <input type="text" class="form-control" name="vin_number"
                                            value="{{ $ad->vin_number }}" id="input-vin_number">
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-odo_meter_reading" class="control-label">ODO Meter
                                            Reading</label>
                                        <input type="text" class="form-control" name="odo_meter_reading"
                                            value="{{ $ad->odo }}" id="input-odo_meter_reading">
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="price" class="control-label">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="price"><i
                                                        class="fa fa-dollar"></i></span>
                                            </div>
                                            <input class="form-control w-75" type="text" name="price"
                                                value="{{ $ad->price }}" aria-describedby="price">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-current_mpg" class="control-label">Current MPG (Miles Per
                                            Gallon)</label>
                                        <select id="input-current_mpg" class="form-control" name="current_mpg">
                                            <option value="">Select MPG</option>
                                            <option value="11" {{ $ad->mpg == 11 ? 'selected' : '' }}>11 or Below
                                            </option>
                                            <?php for ($i = 12; $i < 40; $i++) {?>
                                            <option value="<?=$i?>" {{ $ad->mpg == $i ? 'selected' : '' }}><?=$i?>
                                            </option>
                                            <?php }?>
                                            <option value="40" {{ $ad->mpg == 40 ? 'selected' : '' }}>40 or Above
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-url" class="control-label">URL</label>
                                        <input type="text" class="form-control" name="url" id=" input-url"
                                            value="{{ $ad->url }}">
                                        <span class="small-text">(eg: http://www.example.com)</span>
                                    </div>

                                    <div class="col-md-4 mt-30">
                                        <input id="input-use_address_on_map" type="checkbox" name="use_address_on_map"
                                            value="1" {{ $ad->use_address_on_map ? 'checked' : '' }}>
                                        <label for="input-use_address_on_map" class="form-check-label">Use this on map</label>
                                        <br>
                                        <a href="javascript:void(0)" id="share_location_btn" class="text-primary" onclick="getLocation()">Share Your Location</a>
                                        <span id="location_addr"></span>
                                        <span class="hide" id="share_location_cancel_btn"><a href=""></a></a></span>
                                        <input type="hidden" name="address" id="address" value="">
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-contact_name" class="control-label">Contact Name</label>
                                        <input type="text" class="form-control" name="contact_name"
                                            value="{{ $ad->contact_name ?: $user->first_name . ' ' . $user->last_name }}"
                                            id="input-contact_name">
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-contact_number" class="control-label">Contact Number</label>
                                        <input type="number" class="form-control" name="contact_number"
                                            value="{{ $ad->contact_number ?: $user->mobile }}" id="input-contact_number">
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group">
                                        <label for="input-email" class="control-label d-inline-flex">
                                            <span>Email</span>
                                            <div class="form-check-inline pl-2">
                                                <input class="form-check-input" type="checkbox" name="show_email"
                                                    id="show_email" value="1" {{ $ad->show_email ? 'checked' : '' }}>
                                                <label class="form-check-label cursor-pointer" for="show_email">Show
                                                    Email</label>
                                            </div>
                                        </label>
                                        <input type="text" class="form-control" name="email" id="input-email"
                                            value="{{ $ad->contact_email ?: $user->email }}">
                                    </div>

                                    <!-- state -->
                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-state" class="control-label">State</label>
                                        <select id="input-state" class="form-control" name="states_details">
                                            @foreach ($states_select as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ strtolower($ad->states_details) == strtolower($key) ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                                                            <br>
                                    <label>Selected States </label><br>
                                    <input type="text"  class="form-control" readonly name="state_id" id="state_id" value="{{ $current_state }}" />
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-city" class="control-label">City</label>
                                        <input type="text" id="city" autocomplete="off" value="{{ $city_name }}"
                                            class="form-control input-sm" />
                                        <input type="hidden" name="city_id" id="city_id" value="{{ $ad->city }}"
                                            class="required" />
                                    </div>

                                    <div class="col-md-4 col-sm-4 form-group required">
                                        <label for="input-city" class="control-label">Ad Expiry Date</label>
                                        <input class="form-control" type="text" name="expiry_date" readonly="readonly"
                                            value="{{ format_dp($ad->end_date ?: '', 'front') }}" id="expiry_date">
                                        <input type="hidden" name="ad_type" value="{{ $ad_type }}">
                                        <input type="hidden" name="current_url" value="{{ Request::url() }}">
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success btn-submit">{{ $ad_type_text=='Create Premium Add' ? 'Go to payment' : "Save Ad" }}</button>
                                <a href="{{ route('auto.index') }} " class="btn btn-primary btn-cancel">Cancel</a>
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
        $images_[] = [
            'id' => $key,
            'src' => "{$image}",
        ];
    }
    $images_ = json_encode($images_, true);
    @endphp
    <script type="text/javascript">
        apply_dp('#expiry_date');
        apply_dp('#input-next_date');

         $(document).ready(function () {
            //  $('#input-auto_colors').change(function (e) {
            //      var auto_color = $('#input-auto_colors').data('color');
            //      console.log(auto_color);
            //  });
        });
        $('#input-auto_colors').change(function () {
            var color_val = $('#input-auto_colors').val();
            if(color_val == ""){
                $('#auto_color').addClass('d-none');
            }
            else{
                $('#auto_color').removeClass('d-none');
                var test = $('#input-auto_colors option:selected').data("color");
                $('#auto_color').css('background-color', test);
            }
        });
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

        if($("#input-auto_models option:selected").index() == -1){
            $('#input-auto_models').appendTo($(".auto-models").attr("value", '').text('Select Auto Models'));
        }

        $(function() {
            var auto_models = @json($auto_models);
            var selected_job_role_id = $("#input-auto_makes").val();
            var selected_model = '{{ $ad->model }}';
            var optarray = auto_models.map(function(k, j) {
                return {
                    "value": k.auto_make_id,
                    "option": "<option value='" + k.id + "'>" + k.model_name + "</option>"
                }
            })

            $("#input-auto_makes").on('change', function() {
                // $("#input-auto_models").children('option').remove();
                console.log(optarray);
                var addoptarr = [];
                for (i = 0; i < optarray.length; i++) {
                    if (optarray[i].value == $(this).val()) {
                        addoptarr.push(optarray[i].option);
                    }
                }
                if(addoptarr.length == 0){
                    console.log(addoptarr);
                    $("#input-auto_models").html("<option value=''>Select Auto</option>")
                } else {
                    $("#input-auto_models").html(addoptarr.join(''))
                }
            }).change();

            if (selected_model) {
                $("#input-auto_models").val(selected_model);
            }

        })

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

        var isDirty = function() {
            return false;
        }
        var formSubmitting = false;

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

                    if (json.errors) {
                        $.each(Object.keys(json.errors), function(key, value) {
                            if (value.includes('image')) {
                                $error = true;
                                $ele.after(
                                    "<span class='text-danger alert-dismissable d-block'>" +
                                    json.errors[value] + "</span>");
                            }
                        });
                        if (json['errors']['city_id'] && ($ele1 = $container.find('#city'))) {
                            $ele1.addClass('is-invalid');
                            $ele1.parents(".form-group").addClass("has-error");
                        }

                        if (json['errors']['state_id'] && ($ele2 = $container.find('#input-state'))) {
                            $ele2.addClass('is-invalid');
                            $ele2.parents(".form-group").addClass("has-error");
                        }
                    }

                    if ($error) {
                        $ele.addClass('border border-danger');
                        $ele.parents(".form-group").addClass("has-error");
                    }

                },
            })
            formSubmitting = true;
            return false;
        })

        window.onload = function() {
            window.addEventListener("beforeunload", function(e) {
                if (formSubmitting || !isDirty()) {
                    return undefined;
                }

                var confirmationMessage = 'It looks like you have been editing something. ' +
                    'If you leave before saving, your changes will be lost.';

                (e || window.event).returnValue = confirmationMessage; //Gecko + IE
                return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
            });
        };
    </script>
@endsection
