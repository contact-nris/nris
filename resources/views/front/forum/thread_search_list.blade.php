@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumb-wrapper">
					<h2 class="product-title">Forum</h2>
					<ol class="breadcrumb">
						<li><a href="{{ route('home') }}">Home /</a></li>
						<li><a href=""> Threads /</a></li>
						<li class="current">Forum</li>
					</ol>
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
							<form class="col-12" action="{{ route('front.forum.thread_search') }}" method="get">
								<div class="input-group">
									<input type="text" class="form-control" value="{{ old_get('filter_name') }}" placeholder=" Search" name="filter_name">
									<div class="input-group-append">
										<button class="btn btn-common" type="submit" id="button-filter"><i class="fa fa-search"></i>
											Search Now</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				@if(count($forums))
				<div class="card">
					<div class="card-body p-0">
						<?php foreach ($forums as $key => $forum) {?>
							<div class="forms-list">
								<div class="form-avatar">
									<div class="avatar border">{{ fc($forum->username) }}</div>
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
									<div>Reply: {{$forum->total_reply}}</div>
									<div>VIEW: {{$forum->total_views}}</div>
								</div>
								<div class="form-aside">
									<div class="d-flex">
										<span class="avatar avatar-sm">{{ fc($forum->username) }}</span>
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
				@else
				<div class="alert alert-info mt-3">
					<h4>No Data Found! Try Different Search</h4>
				</div>
				@endif

				<div class="pagination-bar pagination justify-content-center">
					{{ $forums->appends(request()->except('page'))->links('front.pagination') }}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection