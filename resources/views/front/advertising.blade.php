@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Advertise</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Advertise</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-padding">

    <!--<div id="content">-->
    <!--    <div class="container">-->
    <!--        @if(session()->has('success'))-->
    <!--        <div class="alert alert-icon alert-success card-alert">-->
    <!--            <i class="fa fa-check-circle mr-2" aria-hidden="true"></i> {{ session()->get('success') }}-->
    <!--        </div>-->
    <!--        @endif-->

    <!--        @if(session()->has('error'))-->
    <!--        <div class="alert alert-icon alert-danger card-alert">-->
    <!--            <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {{ session()->get('error') }}-->
    <!--        </div>-->
    <!--        @endif-->
    <!--    </div>-->
    <!--</div>-->

    <div class="container">
        <div class="card" style="width:100%;">

            <div class="card-body">

                <form method="post" action="{{ route('front.advertising.submit') }}" class="row" id="form">
                    @csrf
                    <div class="col-12">
                        <h1 class="h1 theme_color">Advertise</h1>
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12 ">
                        <label class="d-block" for="first_name">First Name</label>
                        <input id="first_name" class="form-control" type="text" name="first_name">
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="last_name">Last Name</label>
                        <input id="last_name" class="form-control" type="text" name="last_name">
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="business_name">Business Name</label>
                        <input id="business_name" class="form-control" type="text" name="business_name">
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="email">Email</label>
                        <input id="email" class="form-control" type="text" name="email">
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="web_link">Website Link</label>
                        <input id="web_link" class="form-control" type="text" name="web_link">
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="phone_number">Phone Number</label>
                        <input id="phone_number" class="form-control" type="number" name="phone_number">
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="select_file">File</label>
                        <input id="select_file" class="form-control-file" type="file" name="image" accept="image/*">
                        <small id="fileHelp" class="form-text text-muted fa-1x">Size of the image should be less than 1 MB.</small>
                    </div>

                    <div class="form-group mb-3 col-lg-6 col-md-6 col-xs-12">
                        <label class="d-block" for="description">Description</label>
                        <textarea id="description" class="form-control" name="description" rows="4"></textarea>
                    </div>

                    <div class="form-group mb-3 col-12">
                        <button class="btn btn-common  float-right mt-2"  type="submit">Send</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .font_decoration p {
        font-size: 15px;
        color: black;
        line-height: 23px;
        word-spacing: 1.75px;
        padding: 3px 0px;
    }
</style>

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