@extends('layouts.front')

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">About Us</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">About Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-padding">
    <div class="container">
        <div class="card p-2" style="width:100%;">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <iframe src="https://www.youtube.com/embed/nah7E8wxwdg" width="100%" height="250" frameborder="0"></iframe>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <iframe src="https://www.youtube.com/embed/1paHhQ3QIcM" width="100%" height="250" frameborder="0"></iframe>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12 mt-3">
                    <iframe src="https://www.youtube.com/embed/NS42izvbZ7k" width="100%" height="250" frameborder="0"></iframe>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12 mt-3">
                    <iframe src="https://www.youtube.com/embed/WSL4JidALgo" width="100%" height="250" frameborder="0"></iframe>
                </div>

                <div class="col-lg-12 col-md-12 col-xs-12 font_decoration pl-5 pt-3">
                    <p class="pb-2">Started with a commitment for helping Non Resident Indians Across the world A Great Gift to all NRI'S residing in United States.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;First time a real network for all NRIs in all 51 states in USA </p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;First time for NRI users Live chat option for Nationwide and Statewide.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Fully encrypted and secured personal details with confidential login activity</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Business people who want to make more money hurry up improve your traffic by giving ads with us.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;We are not only commercial but kind hearted too (Fund for Economically poor students in USA)</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Free classifieds to buy stuff or sale stuff hassle free with live negotiation options with buyer and seller.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Forum with almost 40 kind of informative topics</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Deshi Pages for all business listings locally in your state and US nationwide.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Moving out of state dont worry any more...where ever you go NRIS.com is there for you.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Save money in travel ( First time interstate carpool web services exclusively for NRIs).</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Never go to a bad Restaurant, live ratings with real reviews for all kind of food places</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Know your daily horoscope right in your home page.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Know the date and panchagam for that day live.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Live world, USA, Indian news scrolls.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Live stock rates.</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Cheap air tickets to anywhere in the world</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Most popular visiting places in your state and over all USA</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Local movies playing in your nearest cities</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Invite anybody for any kind of personal events</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;check for community and religious events</p>
                    <p><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Check for online webinars and class schedules for all kind of students in teaching and learning</p>
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