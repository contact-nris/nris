@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Search</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Search</li>
                    </ol>
                </div>
            </div>
            <div class="col-12">
                <a href="javascript:void(0)" class="btn btn-success" onclick="return openModel('create_free_ad');">Create Free Ad</a>
                <a href="javascript:void(0)" class="btn btn-warning" onclick="return openModel('create_premium_ad');">Create Premium Ad</a>
            </div>

        </div>
    </div>
</div>

<div class="section-padding">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
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

            <div class="col-lg-12 col-md-12 page-content mt-3">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($search_data as $val)
                                <tr>
                                    <td>
                                        <a href="{{ route( $val['view_route'], $val['slug'] ) }}">
                                            {{ $val['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ dashesToCamelCase($val['type'],true) }}</td>
                                    <td>{{ $val['total_views'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="m-0 text-muted">Total <span>{{ $search_data->total() }}</span> entries</p>
                        {{ $search_data->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function openModel(type) {
        var check = "{{ Auth::check() }}";
        if (!check) {
            auth("login");
            return false;
        } else {
            $.ajax({
                type: "get",
                url: "{{ route('front.getCreateAdUrl') }}" + "/" + type + "/true/true",
                data: {},
                dataType: 'json',
                beforeSend: function() {
                    $('#state-selection .modal-body .row').html('<div class="col-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
                },
                success: function(json) {
                    html = '';
                    if (json.urls) {
                        $.each(json.urls, function(i, j) {
                            html += `<div class="col-md-4 col-sm-6 mt-1 text-center">
                            <a href="${j.link}" class="h3" onclick="return CheckLogin(this);" >
                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="${j.image}" style="width: 55px; height: 55px;"><br>
                            ${j.title}</a></div>`;
                        });
                    }

                    $('#state-selection .modal-header .modal-title').text('Select Category');
                    $('#state-selection .modal-body .row').html(html);
                    $('#state-selection').modal('show');
                }
            });
        }
    }
</script>

@endsection