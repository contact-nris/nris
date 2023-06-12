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
                            <li class="current">Student Talk</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-5 text-right">
                    <a href="{{ route('adduniversity.form') }}" class="btn btn-success py-1"
                        onclick="return CheckLogin(this);">Add New University</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar mt-3">
                    <aside class="bg-white p-2">
                        <form method="get" id="form_ajax">
                            <div class="widget_search position-relative mb-3">
                                <input type="search" class="form-control" autocomplete="off" name="filter_name"
                                    placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                                <button type="button" id="search-submit" class="search-btn"><i
                                        class="fa fa-search"></i></button>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('adduniversity.index') }}" class="btn btn-secondary">Clear
                                    Filter</a>
                                <button class="btn btn-common" type="submit" id="button-filter"><i
                                        class="fa fa-search"></i>Search</button>
                            </div>

                        </form>
                    </aside>
                </div>

                <div class="col-lg-9 col-md-12 col-xs-12 page-content">
                    <div class="adds-wrapper">
                        <div class="tab-content">
                            <div id="list-view" class="tab-pane fade active show">
                                @if (count($lists))
                                    <div class="row">
                                        <?php foreach ($lists as $key => $list) {?>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="featured-box h-auto">

                                                <div class="feature-content update w-100">
                                                    <div class="row mb-2">
                                                        <div class="col-md-2">
                                                            @if ($list->uni_img !== null)
                                                            @php
                                                                if(isset($_GET['test'])){
                                                                    dd($list->uni_img);
                                                                }
                                                            @endphp
                                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('upload/university/'.$list->uni_img) }}"
                                                                    alt="" class="w-100 ">
                                                            @else
                                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('upload/university/default_university.jpg') }}"
                                                                    alt="" class="w-100">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8 pl-0">
                                                            <h1>
                                                                <a href="{{ route('adduniversity.view', ['id' => base64_encode($list->id)]) }}" style="
                                                                    color: var(--main-color);
                                                                "> {{ $list->uni_name }} </a>
                                                            </h1>
                                                            <div class="dsc">{{ $list->ShortDesc }}</div>
                                                            <div class="specification">
                                                                <ul class="list-specification">
                                                                    <div class="row pl-3">
                                                                        <div class="col-md-5 pl-0">
                                                                            <li class="w-100"><i
                                                                                    class="fa fa-globe w-auto"></i><strong>URL
                                                                                    :
                                                                                </strong><a href="{{ $list->url }}"
                                                                                    target="_black">{{ $list->url }}</a>
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-md-5 pl-0">
                                                                            <li class="w-100"><i
                                                                                    class="fa fa-book w-auto"></i><strong>Education
                                                                                    Field : </strong>{{ $list->edu_field }}
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 pl-0">
                                                            <a href="{{ route('adduniversity.view', ['id' => base64_encode($list->id)]) }}"
                                                                class="btn btn-secondary w-100 mb-2">View More</a>
                                                        </div>
                                                    </div>

                                                    <div class="listing-bottom">
                                                        <div class="d-flex justify-content-between">
                                                            <!-- <div>View : {{ $list->total_views }}</div> -->
                                                            <div>Post Date :
                                                                {{ date('H:i:s', strtotime($list['created_at'])) == '00:00:00' ? 'N/A' : date_full($list['created_at']) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                @else
                                    <div class="alert alert-info mt-3">
                                        <h4>No Data Found! Try Different Search</h4>
                                    </div>
                                @endif
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

    <script>
        $('#form_ajax').on('submit', function(e) {
            var url = "{{ route('adduniversity.index') }}";

            var filter_name = $('input[name=\'filter_name\']').val();
            if (filter_name) {
                url += '?filter_name=' + encodeURIComponent(filter_name);
            }

            location = url;
            e.preventDefault();
        });
    </script>
@endsection
