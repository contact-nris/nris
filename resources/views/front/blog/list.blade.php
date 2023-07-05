@extends('layouts.front',$meta_tags)

@section('content')


<?php
$list_box['data'] = array('name' => 'Blog', 'href' => route('front.blog.from'), 'create' => 0, 'type' => 'small');
?>
@include('layouts.listbox')







<div class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar mt-3">
                <aside>
                    <div class="widget_search" action="{{ route('front.blog') }}">
                        <form role="search" id="search-form">
                            <input type="search" class="form-control" autocomplete="off" name="filter_name"
                                placeholder="Search..." id="search-input"
                                value="{{ old_get('filter_name') }}">
                            <button type="submit" id="search-submit" class="search-btn"><i
                                    class="fa fa-search mr-3"></i></button>
                        </form>
                    </div>

                    <div class="widget categories card">
                        <h4 class="widget-title card-header">All Categories</h4>
                        <ul class="categories-list card-body">
                            <li>
                                <a href="{{ route('front.blog') }}">All Category</a>
                            </li>
                            <?php foreach ($categories as $key => $category) {?>
                            <li>
                                <a
                                    href="{{ route('front.blog',['category_id'=>$category->id]) }}">{{ $category->name }}</a>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </aside>
            </div>
            <div class="col-lg-9 col-md-12 col-xs-12 page-content">
                <div class="adds-wrapper">
                    <div class="tab-content">

                        <div id="list-view" class="tab-pane fade active show">
                            <div class="row">
                                <?php foreach ($lists as $key => $list) {?>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="featured-box">
                                        <figure>
                                            <a
                                                href="{{ route('front.blog.view', $list->Slug) }}"><img
                                                    class="img-fluid " src="{{ $list->image_url}}" alt="">

                                                    </a>
                                        </figure>
                                        <div class="feature-content">
                                            <div class="product">
                                                <a href='javascript:void(0)'>{{ $list->category_name }}</a>
                                            </div>
                                            <h4><a
                                                    href="{{ route('front.blog.view', $list->Slug) }}">{{ $list->title }}</a>
                                            </h4>
                                            <div class="meta-tag">
                                                <span class='d-flex'>
                                                    <a href="javascript:void(0)"><i class="fas fa-clock"></i>
                                                        {{ date_with_month($list->created_at) }}</a>
                                                </span>
                                            </div>
                                            <!-- <div class="dsc">
                                                {{ $list->short_desc }}
                                            </div> -->

                                            <div class="listing-bottom">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    @include('layouts.list_like', array(
                                                    'model' => 'blog',
                                                    'model_id' => $list->id,
                                                    'like_count' => count($list->blog_like),
                                                    'dislike_count' => count($list->blog_dislike),
                                                    'user_like_status' => $list->like_status
                                                    ))
                                                    <div>
                                                        <a href="{{ route('front.blog.view', $list->Slug) }}"
                                                            class="btn btn-common">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
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