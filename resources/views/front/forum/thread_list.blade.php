@extends('layouts.front',$meta_tags)

@section('content')

<!--<div class="page-header" style="background: url(assets/img/banner1.jpg);">-->
<!--	<div class="container">-->
<!--		<div class="row">-->
<!--			<div class="col-md-12">-->
<!--				<div class="breadcrumb-wrapper">-->
<!--					<h2 class="product-title">Forum</h2>-->
<!--					<ol class="breadcrumb">-->
<!--						<li><a href="{{ route('front.forum') }}">Forum /</a></li>-->
<!--						<li><a href="">{{ $parentCategory->name }} /</a></li>-->
<!--						<li class="current">Forum</li>-->
<!--					</ol>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->




<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Forum</h2>

                        <p><a href="{{ route('front.forum') }}" class="text-white" style="font-size: 17px;">Forum  /</a>
                            <span
                                style="font-size:17px ;color:var(--main-color)">{{ $parentCategory->name }}/</span>

                                 <span
                                style="font-size:17px ;color:var(--main-color)">Forum</span>
                                 </p>

                    </div>
                </div>

            </div>
            </div>
            </div>



<div class="faq section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<form class="col-10" action="{{ route('front.forum.thread_search') }}" method="get">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" name="filter_name">
									<div class="input-group-append">
										<button class="input-group-text" id="basic-addon2" type="sumbit"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</form>
							<div class="col-2">
								<a href="{{ route('front.forum.create', $sub_category_id_encode ) }}" onclick="return LoginFrom(this);" class="btn btn-common">Create Topic</a>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h2 class="card-title m-0"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Recent Threads</h2>
					</div>
					<div class="card-body p-0">
						<?php foreach ($forums_recent as $key => $forum) {?>
							<div class="forms-list">
								<div class="form-avatar">
									<span class="avatar avatar-sm">{{ fc($forum->title) }}</span>
								</div>
								<div class="form-body">
									<a href="{{ route('front.forum.view', $forum->slug) }}">
										<h3 class="mb-0">{{ $forum->title }}</h3>
									</a>
									<div>
										<div class="forum-user">{{ $forum->username }}</div>
										<div class="date">{{ date_f($forum->created_at) }}</div>
									</div>
								</div>
								<div class="form-counter">
									<div>Reply: {{ count($forum->comments) }}</div>
									<div>VIEW: {{$forum->total_views}}</div>
								</div>
								<div class="form-aside">
									<div class="d-flex">
										<img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ user_profile($forum->profile_photo, $forum->username) }}" class="avatar avatar-sm" alt="{{ $forum->username }}">
										<div class="ml-2">
											<div class="name text-capitalize">{{ $forum->username }}</div>
											<div class="date">{{ date_f($forum->created_at) }}</div>
										</div>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h2 class="card-title m-0"><i class="fa fa-fire"></i> Popular Threads</h2>
					</div>
					<div class="card-body p-0">
						<?php foreach ($forums as $key => $forum) {?>
							<div class="forms-list">
								<div class="form-avatar">
									<span class="avatar avatar-sm">{{ fc($forum->title) }}</span>
								</div>
								<div class="form-body">
									<a href="{{ route('front.forum.view', $forum->slug) }}">
										<h3 class="mb-0">{{ $forum->title }}</h3>
									</a>
									<div>
										<div class="forum-user"><i class="fa fa-user"></i> {{ $forum->username }}</div>
										<div class="date"><i class="fa fa-calendar"></i> {{ date_f($forum->created_at) }}</div>
									</div>
								</div>
								<div class="form-counter">
									<div>Reply: {{count($forum->comments)}}</div>
									<div>VIEW: {{$forum->total_views}}</div>
								</div>
								<div class="form-aside">
									<div class="d-flex">
										<img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ user_profile($forum->profile_photo, $forum->username) }}" class="avatar avatar-sm" alt="{{ $forum->username }}">
										<div class="ml-2">
											<div class="name text-capitalize">{{ $forum->username }}</div>
											<div class="date">{{ date_f($forum->created_at) }}</div>
										</div>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
				</div>

				<div class="pagination-bar pagination justify-content-center">
					{{ $forums->appends(request()->except('page'))->links('front.pagination') }}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection