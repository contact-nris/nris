@extends('layouts.front')

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Contact Us</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Contact Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-padding">
    <div class="container">
        <div class="card" style="width:100%;">
            <div class="row">
                <div class="col-12 font_decoration mt-3 pl-4">
                    <h1 class="h1 theme_color">Contact Us</h1>
                    <p>For Business, partnership and Corporate affairs Please contact us at <a href="mailto:contact@nris.com" class="text-success"><b>contact@nris.com</b></a>.</p>
                    <p>For suggestions, Complaints and enquiries contact at <a href="mailto:info@nris.com" class="text-danger"><b>info@nris.com</b></a>.</p>
                </div>
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

@endsection