@extends('layouts.front',$meta_tags)

@section('content')



<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Forum</h2>

                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a>
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
		<div class="card">
			<div class="card-header">
				<div class="row">
					<form class="col-md-12" action="{{ route('front.forum.thread_search') }}" method="get">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" name="filter_name">
							<div class="input-group-append">
								<button class="input-group-text" id="basic-addon2" type="sumbit"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel-group" id="accordion">
					<?php foreach ($category as $key => $cate) {?>
						<div class="panel panel-default">
							<div class="panel-heading" style="background: <?=$cate->category_color?>;">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$cate->id?>">
										{{$cate->name}}
									</a>
								</h4>
							</div>
							<div id="collapse<?=$cate->id?>" class="panel-collapse collapse show">
								<div class="panel-body p-0">
									<?php if (count($forums[$cate->id]) == 0) {?>
										<div class="text-center py-3">There are no any forum thread in <u>{{$cate->name}}</u></div>
									<?php }?>
									<?php foreach ($forums[$cate->id] as $key => $forum) {?>
										<div class="border-bottom py-2 px-4">
											<div class="row align-items-center">
												<div class="col-auto">
													<span class="avatar" style="background-image: url('{{ asset('upload/forum').'/'.$forum->sub_cate_img }}');"></span>
												</div>
												<div class="col">
													<div class="text-truncate">
														<a href="{{ route('front.forum_subcate', base64_encode($forum->sub_category_id)) }}"><h3 class="mb-0"><?=$forum->sub_cate?></h3></a>
														<div>{{ $forum->title }}</div>
													</div>
													<div class="text-muted mt-1">
														Reply: {{$forum->total_reply}}
														VIEW: {{$forum->total_views}}
													</div>
												</div>
												<div class="col-auto" style="min-width: 200px;">
													<div class="d-flex">
														<img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ user_profile($forum->profile_photo, $forum->username, $cate->category_color) }}" class="avatar avatar-sm" alt="{{ $forum->username }}">
														<div class="ml-2">
															<div class="name text-capitalize">{{ $forum->username }}</div>
															<div class="date">{{ date_f($forum->created_at) }}</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php }?>
								</div>
							</div>
						</div>
					<?php }?>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection