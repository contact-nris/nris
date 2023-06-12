@extends('layouts.front', $meta_tags)

@section('content')
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">{{ $university ? $university['uni_name'] : 'Student Talk' }}</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('adduniversity.index') }}">Student Talk /</a></li>
                            <li class="current">University</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-5 text-right">
                    <a href="{{ route('adduniversity.topic_form') }}" class="btn btn-success py-1"
                        onclick="return CheckLogin(this);">Create a Post</a>
                         <a href="{{ route('adduniversity.form') }}" class="btn btn-success py-1"
                        onclick="return CheckLogin(this);">Add University</a>
                </div>
            </div>
        </div>
    </div>



    <div class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-md-0">
                    <div class="university_box">
                        <p class="uni_box_tittle">Accommodation</p>
                        @if (count($accommodation))
                            <ol>
                                @foreach ($accommodation as $key => $item)
                                    <li class="uni_title">
                                        <a
                                            href="{{ route('studenttalk.view', ['slug' => $item->slug]) }}">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                                <a class="uni-more"
                                    href="{{ route('topic.list', ['topic' => base64_encode($item->type), 'uni' => request()->id]) }}">View
                                    More</a>
                            </ol>
                        @else
                            <ol>
                                <li class="uni_title">
                                    Data Not Found
                                </li>
                            </ol>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 p-md-0">
                    <div class="university_box">
                        <p class="uni_box_tittle">Campus Jobs</p>
                        @if (count($campusJobs))
                            <ol>
                                @foreach ($campusJobs as $key => $item)
                                    <li class="uni_title">
                                        <a
                                            href="{{ route('studenttalk.view', ['slug' => $item->slug]) }}">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                                <a class="uni-more"
                                    href="{{ route('topic.list', ['topic' => base64_encode($item->type), 'uni' => request()->id]) }}">View
                                    More</a>
                            </ol>
                        @else
                            <ol>
                                <li class="uni_title">
                                    Data Not Found
                                </li>
                            </ol>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 p-md-0">
                    <div class="university_box">
                        <p class="uni_box_tittle">Assignment Help</p>
                        @if (count($ChangeGroups))
                            <ol>
                                @foreach ($ChangeGroups as $key => $item)
                                    <li class="uni_title">
                                        <a
                                            href="{{ route('studenttalk.view', ['slug' => $item->slug]) }}">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                                <a class="uni-more"
                                    href="{{ route('topic.list', ['topic' => base64_encode($item->type), 'uni' => request()->id]) }}">View
                                    More</a>
                            </ol>
                        @else
                            <ol>
                                <li class="uni_title">
                                    Data Not Found
                                </li>
                            </ol>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 p-md-0">
                    <div class="university_box">
                        <p class="uni_box_tittle">Other Topics</p>
                        @if (count($other))
                            <ol>
                                @foreach ($other as $key => $item)
                                    <li class="uni_title">
                                        <a
                                            href="{{ route('studenttalk.view', ['slug' => $item->slug]) }}">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                                <a class="uni-more"
                                    href="{{ route('topic.list', ['topic' => base64_encode($item->type), 'uni' => request()->id]) }}">View
                                    More</a>
                            </ol>
                        @else
                            <ol>
                                <li class="uni_title">
                                    Data Not Found
                                </li>
                            </ol>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
