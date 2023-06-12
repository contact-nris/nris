@extends('layouts.front', $meta_tags)

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Blog</h2></h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('front.blog') }}">Blog /</a></li>
                        <li class="current">Create Blog</li>
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
                        <h3>Create Blog</h3>
                    </div>
                    <form method="post" action="{{ route('front.blog.SubmitFrom', [$id]) }}" enctype="multipart/form-data" id="form">
                        <div class="card-body text-black create-ad">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-title" class="control-label">Title</label>
                                    <input type="text" class="form-control" id="input-title" value="{{ $ad->title }}" name="title" placeholder="Enter title here">
                                    <span class="form-text text-muted">Only alphabets, numbers and spaces are allowed</span>
                                </div>

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-description" class="control-label">Description</label>
                                    <textarea class="form-control" id="input-description" name="description" rows="3" placeholder="Enter description here">{{ $ad->message }}</textarea>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required">
                                    <label for="input-category_types" class="control-label">Select Blog Category</label>
                                    <select id="input-category_types" class="form-control" name="category">
                                        <option value="">Select Blog category</option>
                                        @foreach($category as $key => $type)
                                        <option value="{{ $type->id }}" {{ $ad->category == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 form-group required d-none">
                                    <label for="input-category_types" class="control-label">Select Ads Category</label>
                                    <select id="input-category_types" class="form-control" name="visibility">
                                        <option value="Public">Select Blog Visibility</option>
                                        <option value="Public" {{ $ad->visibility == 'Public' ? 'selected' : '' }} >Public</option>
                                        <option value="Private" {{ $ad->visibility == 'Private' ? 'selected' : '' }} >Private</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-12 form-group">
                                    <label class="" for="inputGroupFile02">Blog Image</label>
                                    <div class="custom-file">
                                        <input type="file" name="blog_img" class="custom-file-input" id="inputGroupFile02">
                                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                    </div>
                                    <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">Create Blog</button>
                            <a href="{{ route('front.babysitting.list')}} " class="btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
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