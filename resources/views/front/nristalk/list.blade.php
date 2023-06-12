@extends('layouts.front',$meta_tags)

@section('content')
<?php
$list_box['data'] = array('name' => 'NRIS Talk', 'href' => route('front.nristalk.create', 'create_free_ad'), 'create' => 1, 'type' => 'small');
?>
@include('layouts.listbox')


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
                            <button class="btn btn-common" type="submit" id="button-filter"><i class="lni-search"></i>
                                Search Now</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="card">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Title</th>
                                <th>Views</th>
                                <th>Like</th>
                                <th>Comments</th>
                                <th>Posted On</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            @foreach ($lists as $list)
                            <tr>
                                <td class="text-left"><a href="{{ route('front.nris.view',$list->slug) }}" class="text-dark">{{ $list->title }}</a></td>
                                <td class="text-left">{{ $list->total_views }}</a></td>
                                <!-- <td class="text-left">{{ $list->like_count }}</td> -->
                                <td class="text-left">{{ count($list->like_nris) }}</td>
                                <td class="text-left">{{ count($list->comments) }}</td>
                                <td class="text-left">{{ date_with_month($list->created_at) }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="card-footer">
                        {{ $lists->appends(request()->except('page'))->links('front.pagination') }}
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</div>

@endsection