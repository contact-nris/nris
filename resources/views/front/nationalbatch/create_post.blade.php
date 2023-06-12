@extends('layouts.front', $meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Training & Placement</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('nationalbatch.index') }}">Training & Placement /</a></li>
                        <li class="current">Create Ad</li>
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
                        <h3>Batches</h3>
                    </div>
                    <form method="post" action="{{ route('front.nationalbatch.submit_ad',['id' => $ad->id]) }}" enctype="multipart/form-data" id="form">
                        <div class="card-body text-black create-ad">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-title" class="control-label">Name</label>
                                    <input type="text" class="form-control" id="input-title" name="title" value="{{ $ad->title }}" placeholder="Enter title here">
                                    <span class="form-text text-muted">Only alphabets, numbers and spaces are allowed</span>
                                </div>

                                <div class="col-md-6 col-12 form-group">
                                    <label for="input-image" class="control-label">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="images" id="inputGroupFile02">
                                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                      </div>
                                </div>

                                <div class="col-md-6 col-12 form-group required">
                                    <label for="input-category" class="control-label">Batche Type</label>
                                    <select id="input-category" class="form-control" name="category">
                                        <option value="">Choose Type</option>
                                        @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}" {{ $ad->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-description" class="control-label">Description</label>
                                    <textarea class="form-control" id="input-description" name="description" rows="3" placeholder="Enter description here">{{ $ad->message }}</textarea>
                                </div>


                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-description" class="control-label">Other Details</label>
                                    <textarea class="form-control" id="input-description" name="otherdetails" rows="3" placeholder="Enter description here">{{ $ad->message }}</textarea>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group">
                                    <label for="input-email" class="control-label d-inline-flex">E-mail</label>
                                    <input type="text" class="form-control" name="email" id="input-email" value="{{ $ad->contact_email ?: $user->email }}">
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-city" class="control-label">Ad Expiry Date</label>
                                    <input class="form-control" type="text" name="expiry_date" id="expiry_date" placeholder="Expiry Date" readonly="readonly" value="{{ format_dp($ad->end_date ?: '', 'front') }}">
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                </div>

                                <div class="col-md-4 col-12 form-group required">
                                    <label for="input-state" class="control-label">Select State</label>
                                    <select id="input-state" class="form-control" name="state_id">
                                        <option value="">Choose State</option>
                                        @foreach($states_list as $key => $state)
                                        <option value="{{ $state->code }}" {{ $ad->state_code == $state->code ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">Save Ad</button>
                            <a href="{{ route('nationalbatch.index') }}" class="btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    apply_dp('#expiry_date');

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

                if(json.errors) {
                    $.each(Object.keys(json.errors), function(key, value) {
                        if (value.includes('image')) {
                            $error = true;
                            $ele.after("<span class='text-danger alert-dismissable d-block'>" + json.errors[value] + "</span>");
                        }
                    });
                    if (json['errors']['city_id'] && ($ele1 = $container.find('#city'))) {
                        $ele1.addClass('is-invalid');
                        $ele1.parents(".form-group").addClass("has-error");
                    }
                }

                if ($error) {
                    $ele.addClass('border border-danger');
                    $ele.parents(".form-group").addClass("has-error");
                }

            },
        })

        return false;
    })
</script>
@endsection