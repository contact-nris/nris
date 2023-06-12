@extends('layouts.front',$meta_tags)

@section('content')



<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Create Carpool</h2>

                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a>
                            <span
                                style="font-size:17px ;color:var(--main-color)">Create Carpool</span>
                                 </p>
                    </div>

                </div>
                <div class="col-md-7">
                @include('front.business_item', ['place_name' => $page_type])
               </div>
                <div class="col-lg-5 col-md-12 text-center text-lg-right">
                    <a href="{{ route('addcarpool.form') }}"
                        class="btn btn-success col-lg-6 col-md-4 my-1 py-1" onclick="return CheckLogin(this);">Create Carpool</a>

                </div>
            </div>
            </div>
            </div>


<div class="section-padding">

    <div class="container">

        <div class="product-info row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="details-box bg-white">
                    <div class="my-1 search-bar">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="border border-dark mb-3 search-inner">
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
                    </div>

                    <div class="ads-details-info">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>From City</th>
                                    <th>To City</th>
                                    <th>Start Date</th>
                                    <th>Start Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($lists))
                                @foreach ($lists as $key => $list)
                                <tr>
                                    <td>{{$list->c1_name}}</td>
                                    <td>{{$list->c2_name}}</td>
                                    <td>{{$list->s_date}}</td>
                                    <td>{{$list->s_time}}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No results found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="pagination-bar pagination justify-content-center">
                            {{ $lists->appends(request()->except('page'))->links('front.pagination') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
                <aside class="details-sidebar">
                    <div class="widget card">
                        <h4 class="widget-title card-header">Map Container</h4>
                        <div class="agent-inner card-body">

                            <div class="map-container p-0 mt-3 ">
                                <?php
if ($lists['address'] != "") {
	$address = $lists['address'];
} else {
	$address = $lists['city'] . ', United States';
}
?>

                                <iframe width="100%" height="250" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?=config('app.map_key')?>&q=<?=urlencode($address)?>" allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

        </div>
    </div>

</div>
<script type="text/javascript">
    $("#form").submit(function() {
        $this = $(this);
        $.ajax({
            url: $this.attr("action"),
            type: 'POST',
            dataType: 'json',
            data: new FormData($this[0]),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $this.find(".btn-submit").btn("loading");
            },
            complete: function() {
                $this.find(".btn-submit").btn("reset");
            },
            success: function(json) {
                json_response(json, $this);
            },
        })

        return false;
    })
</script>
@endsection