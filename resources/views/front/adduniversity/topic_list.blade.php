@extends('layouts.front', $meta_tags)

@section('content')
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Student Talk</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('adduniversity.index') }}">Student Talk /</a></li>
                            <li><a href="{{ route('adduniversity.view', ['id' => base64_encode($uni->id)]) }}">{{ $uni->uni_name }}
                                    /</a></li>
                            <li class="current">{{ base64_decode(request()->topic) }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-padding" style="
        min-height: 272px;
">
        <div class="container">
            <div class="row">
                @foreach ($topic_list as $item)
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="featured-box">
                            <div class="feature-content w-100">
                                <h4><a
                                        href="{{ route('studenttalk.view', ['slug' => $item->slug]) }}">{{ $item['title'] }}</a>
                                </h4>
                                <p class="pb-2" style="word-break: break-word;">{{ $item->ShortDesc }}</p>
                                <div class="listing-bottom py-2">
                                    <div class="d-flex justify-content-between">
                                        <div>Date: {{ date_full($item['created_at']) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-bar pagination justify-content-center">
                {{ $topic_list->appends(request()->except('page'))->links('front.pagination') }}
            </div>
        </div>
    </div>
@endsection
