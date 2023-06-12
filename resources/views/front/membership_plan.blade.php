@extends('layouts.front',$meta_tags)

@section('content')
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Membership Plans</h2>
                        <ol class="breadcrumb">
                            <li><a href="https://nris.com">Home /</a></li>
                            <li class="current">Membership Plans</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-around py-5" id="ads">
            <!-- Category Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-image">
                        <span class="card-notify-badge">YEARLY</span>
                        <span class="card-notify-year">$10</span>
                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('year_card.png') }}" class="w-100"
                            style="width: 200px; border-radius: 9px;">
                    </div>
                    <div class="card-body text-center">
                        <div class=" m-auto">
                            <h5 class="text-capitalize font-weight-bold fa-2x">Yearly Membership</h5>
                        </div>
                        <a class="btn btn-common text-capitalize btn-block mt-3" href="{{ route('cardbuy.startPayment','yearly') }}">Pay now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form class="paypal" action="{{ route('membership.pay') }}" id="paypal_form">
                    <div class="card">
                        <div class="card-image">
                            <span class="card-notify-badge">LIFE TIME</span>
                            <span class="card-notify-year">$100</span>
                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('nris_card.jpg') }}" class="w-100"
                                style="width: 200px; border-radius: 15px;">
                        </div>
                        <div class="card-body text-center">
                            <div class=" m-auto">
                                <h5 class="text-capitalize font-weight-bold fa-2x">Life Membership</h5>
                            </div>
                            <a class="btn btn-common text-capitalize btn-block mt-3" href="{{ route('cardbuy.startPayment','lifetime') }}">Pay now</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
