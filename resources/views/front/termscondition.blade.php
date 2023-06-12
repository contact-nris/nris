@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">TERMS & CONDITIONS</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">TERMS & CONDITIONS</li>
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
                    <h1 class="h1 theme_color">TERMS & CONDITIONS</h1>
                    <p>I am responsible for whatever the content I post at any section of this site, to respect that I do not post any content, rate or reply/review that may be considered, abusive, vulgar, offensive, obscene.</p>
                    <p>Site Management is not responsible for any violations as per law.</p>
                    <p>This site is for public for free use I always maintain courtesy, if I am a business person/organization, marketing person or any other soliciting person I pledge that I will not post repeated Ads, if I do any of this kind of activities, site management have right to find the IP address or delete my ID and barred for future postings from this IP address permanently.</p>
                    <p>We respect Privacy according to US and Global laws, by agreeing to these terms I honor that I never post other's information like name, phone numbers, email addresses and physical addresses etc.</p>
                    <p>I never do spam, no repeated ads in any of the sections with useless content, and I agree I am responsible to open any external links/URLs posted by other users and/or by Admin.</p>
                    <p>I am agreeing that after I accept these terms & conditions I am solely responsible for whatever the content posted here or shared here in public chat.</p>
                    <p>NRIS.COM Reserves all right to remove or delete any user permanently without any reason or prior notification.</p>
                    <p>I am authorizing NRIS.com to track my IP address all the time for legal reasons.</p>
                    <p>I always respect all other users of this site, and I expect the same from other users of this site.</p>
                    <p>Furthermore, I agree that public chat is limited just to share the views of political issues, movies, sports and educational issues and I respect the same and I never use unparliamentary, unlawful, abusive, vulgar words or phrases at any time.</p>
                    <p>We thank you in advance for your understanding and continued support.</p>
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