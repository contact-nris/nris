@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg);">
    <div class="container m-t-124">
        <div class="row">
            <div class="col-md-7">
                <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Training & Placement </h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current"><?php if (isset($cat)) {echo $cat->name;} else {echo "Training & Placement";}?></li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-5 pt-3 text-right">
                <a href="{{ route('front.nationalbatch.create_ad') }}"
                    class="btn btn-success py-1" onclick="return CheckLogin(this);">Create Ad</a>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 page-content">
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="list-view" class="tab-pane fade active show">
                        @if (count($batches))
                            <div class="row">
                                <?php foreach ($batches as $key => $list) {?>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="featured-box">
                                            <figure>
                                                <a href="{{route('nationalbatch.view', $list->slug ) }}">
                                                    @if (!empty($list->image_url))
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" src="{{ $list->image_url }}" alt="">
                                                    @else
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" src="{{ asset('upload/national_batches/commen.jpg') }}" alt="">
                                                    @endif
                                                </a>
                                            </figure>
                                            @if(App\BusinessHour::where(array('model' => 'f_batche', 'model_id' => $list->id, 'is24' => 1))->get()->first())

                                                <span class="bg-success p-2 position-absolute text-white" style="top:15px;right:16px;">24/7 open</span>

                                            @endif
                                            <div class="feature-content">
                                                <h4><a href="{{ route('nationalbatch.view', $list->slug) }}">{{ $list->ShortTitle }}</a>
                                                </h4>
                                                <div class="listing-bottom">
                                                    <div class="d-flex justify-content-between">
                                                        <div>Date: {{ date('Y-m-d',strtotime($list->created_at)) }}</div>
                                                        <div>Views: {{ $list->total_views }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        @else
                            <div class="alert alert-info mt-3">
                                <h4>No results found! Try Different Search</h4>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="pagination-bar pagination justify-content-center">
                    {{ $batches->appends(request()->except('page'))->links('front.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection