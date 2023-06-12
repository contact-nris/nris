@if ($list_box['data']['type'] == 'small')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">{{$list_box['data']['name']}}</h2>
                        
                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a> 
                            <span
                                style="font-size:17px ;color:var(--main-color)">{{$list_box['data']['name']}}</span>
                                 </p>
                    </div>
                </div>
                
                <?php
                 if($list_box['data']['create']) {
                if(Auth::check()) { ?>
                <div class="col-lg-5 col-md-12 text-center text-lg-right">
                    <a href={{$list_box['data']['href']}}
                        class="btn btn-success col-lg-6 col-md-4 my-1 py-1">Create {{$list_box['data']['name']}}</a>
                        </div>
                <?php }else{ ?>
                <div class="col-lg-5 col-md-12 text-center text-lg-right">
                    <a  href={{$list_box['data']['href']}}
                        class="btn btn-success col-lg-6 col-md-4 my-1 py-1" onclick="return CheckLogin(this);">Create {{$list_box['data']['name']}}</a>
                 
                </div>
                <?php }
                }  ?>
            </div>
            </div>
            </div>
@else


<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">{{$list_box['data']['name']}}</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{$list_box['data']['href']}}">{{$list_box['data']['name']}} /</a></li>
                        <li class="current">{{ $list->title }}</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-5 text-right">
                <a href="{{ route('front.national_autos.create_ad', 'create_free_ad') }}" class="btn btn-success py-1" onclick="return CheckLogin(this);">Create Free Ad</a>
                <a href="{{ route('front.national_autos.create_ad', 'create_premium_ad') }}" class="btn btn-warning py-1" onclick="return CheckLogin(this);">Create Premium Ad</a>
            </div>
        </div>
    </div>
</div>



@endif