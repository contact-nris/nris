@extends('layouts.front')

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Disclaimer</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Disclaimer</li>
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
                    <h1 class="h1 theme_color">Disclaimer</h1>
                    <p>If you see any copy righted data please bring it to our notice at <a href="mailto:info@nris.com">info@nris.com</a> we will take action in no time, And all the components in our site are patent pending ideas with patent number NY/PN8PT/177880YN, copying the designs, data and ideas from this website is liable for lawsuit.</p>
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