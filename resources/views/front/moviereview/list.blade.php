@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Movie Review</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Movie Review</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 p-0 mx-5 mx-lg-0">
                <div class="search-bar">
                    <div class="search-inner">
                        <form class="search-form" method="get">
                            <div class="form-group inputwithicon">
                                <input type="search" class="form-control" autocomplete="off" name="filter_name" placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                            </div>
                            <button class="btn btn-common" type="submit" id="button-filter"><i class="lni-search"></i>Search Now</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 mt-1 page-content">
                <div class="adds-wrapper">
                    <div class="tab-content">

                        <div id="list-view">
                            <div class="row">
                                @include('front.moviereview.card', ['card_count' => 3])
                            </div>
                        </div>
                    </div>
                </div>


                <div class="pagination-bar pagination justify-content-center">
                    {{ $lists->appends(request()->except('page'))->links('front.pagination') }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection