@extends('layouts.front',$meta_tags)

@section('content')



  <div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">National Auto</h2>
                        <!-- <ol class="breadcrumb">
                            <li><a href="http://127.0.0.1:8000/">Home /</a></li>
                            <li class="current">Education &amp; Teaching</li>
                        </ol> -->
                        <p><a href="{{ route('home') }}" class="text-white" style="font-size: 17px;">Home /</a>
                            <span
                                style="font-size:17px ;color:var(--main-color)">National Auto</span>
                                 </p>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 text-center text-lg-right">
                    <a href="{{ route('front.national_autos.create_ad','create_free_ad' ) }}"
                        class="btn btn-success col-lg-6 col-md-4 my-1 py-1" onclick="return CheckLogin(this);">Create
                        Free Ad</a>
                    <a href="{{ route('front.national_autos.create_ad','create_premium_ad' ) }}"
                        class="btn btn-warning col-lg-6 col-md-4 my-1 py-1" onclick="return CheckLogin(this);">Create
                        Premium Ad</a>
                </div>
            </div>
        </div>
    </div>

    <?php
//  $list_box['data'] = array(
//  'name' => 'National Auto' ,
//  'href' => "{{ route('auto.index') }}" ,
//  'ad1'=> "{{ route('front.national_autos.create_ad', 'create_free_ad') }}",
//  'ad2'=> "{{ route('front.national_autos.create_ad', 'create_premium_ad') }}",
//  'create' => 1  ,
//  'type' =>'big',
//  'title' => ''
//  );
//  include('layouts.listbox')
?>



        <!-- @include('layouts.category_hor',$adv) -->


<div class="section-padding row mx-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar mt-3">
                <aside class="bg-white p-2">
                    <form method="get" id="search-form">
                        <div class="widget_search position-relative">
                            <input type="search" class="form-control" autocomplete="off" name="filter_name" placeholder="Search..." id="search-input" value="{{ old_get('filter_name') }}">
                            <button type="button" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
                        </div>


                        <div class="form-group">
                            <select name="city_code" class="city_dropdown form-control w-100">
                                <option value="">Select City</option>
                                <?php foreach ($cities as $key => $city) {?>
                                    <option <?=$city->id == old_get('city_code') ? 'selected' : ''?> value="<?=$city->id?>">
                                        {{ $city->name }}
                                    </option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header card-heading-title" id="headingOne">
                                    <a class="collapsed text-black" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="false" aria-controls="collapse0" data-target="#collapse0">Select Make & Model</a>
                                </div>

                                <div id="collapse0" class="collapse {{ old_get('make') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="p-2">
                                        <label>Select Make</label>
                                        <select id="input-auto_makes" class="form-control" name="make">
                                            <option value=''>Select Make</option>
                                            @foreach($auto_makes as $key => $auto)
                                            <option value="{{ $auto->id }}" {{ old_get('make') == $auto->id ? 'selected' : '' }}>{{ $auto->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="p-2">
                                        <label>Select Auto Models</label>
                                        <select id="input-auto_models" class="form-control" name="auto_models">
                                            <option value="">Select Auto Models</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-heading-title" id="headingOne">
                                    <a class="collapsed text-black" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" data-target="#collapseOne">Select Condition</a>
                                </div>

                                <div id="collapseOne" class="collapse {{ old_get('condition') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="p-2">
                                        <div class="btn-group btn-group-toggle d-block" id="collapseOne" data-toggle="buttons">
                                            @foreach($auto_properties['condition'] as $value)
                                            <label class="btn btn-outline-dark m-1 {{ (old_get('condition') && in_array($value, old_get('condition'))) ? 'active' : '' }}">
                                                <input type="checkbox" name="condition[]" value="{{ $value }}" {{ (old_get('condition') && in_array($value, old_get('condition'))) ? 'checked' : '' }} > {{ dashesToCamelCase($value,true) }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-heading-title" id="headingOne">
                                    <a class="collapsed text-black" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2" data-target="#collapse2">Select Transmission</a>
                                </div>

                                <div id="collapse2" class="collapse {{ old_get('transmission') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="p-2">
                                        <div class="btn-group btn-group-toggle d-block" id="collapse2" data-toggle="buttons">
                                            @foreach($auto_properties['transmission'] as $value)
                                            <label class="btn btn-outline-dark m-1 {{ (old_get('transmission') && in_array($value, old_get('transmission'))) ? 'active' : '' }}">
                                                <input type="checkbox" name="transmission[]" value="{{ $value }}" {{ (old_get('transmission') && in_array($value, old_get('transmission'))) ? 'checked' : '' }} > {{ ucfirst($value) }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-heading-title" id="headingOne">
                                    <a class="collapsed text-black" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3" data-target="#collapse3">Select Cylinder</a>
                                </div>
                                <div id="collapse3" class="collapse {{ old_get('cylinder') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="p-2">
                                        <div class="btn-group btn-group-toggle d-block" id="collapse3" data-toggle="buttons">
                                            @foreach($auto_properties['cylinder'] as $value)
                                            <label class="btn btn-outline-dark m-1  {{ (old_get('cylinder') && in_array($value, old_get('cylinder'))) ? 'active' : '' }} ">
                                                <input type="checkbox" name="cylinder[]" value="{{ $value }}" {{ (old_get('cylinder') && in_array($value, old_get('cylinder'))) ? 'checked' : '' }} > {{ dashesToCamelCase($value, true) }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-heading-title" id="headingOne">
                                    <a class="collapsed text-black" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4" data-target="#collapse4">Select Auto Type</a>
                                </div>
                                <div id="collapse4" class="collapse {{ old_get('type') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="p-2">
                                        <div class="btn-group btn-group-toggle d-block" id="collapse4" data-toggle="buttons">
                                            @foreach($auto_properties['type'] as $value)
                                            <label class="btn btn-outline-dark m-1 {{ (old_get('type') && in_array($value, old_get('type'))) ? 'active' : '' }}">
                                                <input type="checkbox" name="type[]" value="{{ $value }}" {{ (old_get('type') && in_array($value, old_get('type'))) ? 'checked' : '' }} > {{ dashesToCamelCase($value, true) }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-heading-title" id="headingOne">
                                    <a class="collapsed text-black" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5" data-target="#collapse5">Select Drive Train</a>
                                </div>
                                <div id="collapse5" class="collapse {{ old_get('drive_train') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="p-2">
                                        <div class="btn-group btn-group-toggle d-block" id="collapse5" data-toggle="buttons">
                                             @foreach($auto_properties['drive_train'] as $value)
                                            <label class="btn btn-outline-dark m-1 {{ (old_get('drive_train') && in_array($value, old_get('drive_train'))) ? 'active' : '' }}">
                                                <input type="checkbox" name="drive_train[]" value="{{ $value }}" {{ (old_get('drive_train') && in_array($value, old_get('drive_train'))) ? 'checked' : '' }} > {{ dashesToCamelCase($value, true) }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group color_select px-2">
                             <span class="d-block h4 text-black">Select Color</span>
                             @foreach($auto_colors as $key => $auto)
                            <input type="checkbox" name="color[]" id="color_type_{{ $auto->id }}" value="{{ $auto->id }}" {{ (old_get('color') && in_array($auto->id, old_get('color')) ) ? 'checked' : '' }} />
                            <label for="color_type_{{ $auto->id }}"><span style="background:{{ $auto->code }}" class="{{ \Str::slug($auto->name,'_') }}"></span></label>
                            @endforeach
                         </div>

                        <div class="form-group">
                            <select id="input-year" class="form-control" name="min_year">
                                <option value="">Select Minimum Year</option>
                                <?php for ($i = (int) date("Y"); $i >= 1955; $i--) {?>
                                    <option value="<?=$i;?>" {{ $i == old_get('min_year') ? 'selected' : '' }} ><?=$i;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-around">
                            <a href="{{ route('auto.index') }}" class="btn btn-secondary">Clear Filter</a>
                            <button class="btn btn-common" type="submit" id="button-filter"><i class="fa fa-search"></i>Search</button>
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
                                        <div class="featured-box">
                                            <figure class="update position-relative">
                                                <a href="{{route('auto.view', $list->slug ) }}">
                                                    <?php if (!empty($list->images)) {?>
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" src="{{ array_values($list->images)[0] }}" alt="">
                                                    <?php } else {?>
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" src="{{ asset('upload/commen_img/auto.png') }}" alt="">
                                                    <?php }?>
                                                </a>
                                                @if($list->images)
                                                    <div class="small_image">
                                                    @foreach($list->images as $image)
                                                        <div class="item">
                                                            <a target="_blank" class="fancybox" rel="{{ $list->title }}" href="{{ $image }}">
                                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="img-fluid" width="50" src="{{ $image }}" alt="{{ $list->title }}">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                @endif
                                            </figure>

                                            <div class="feature-content update">
                                                <div class="product">
                                                    <a href="javascript:void(0)">{{$list->auto_makes_name}} &gt; </a>
                                                    <a href="javascript:void(0)">{{$list->model_name}}</a>
                                                </div>
                                                <h4><a href="{{route('auto.view', $list->slug ) }}">{{$list->ShortTitle}}</a>
                                                </h4>
                                                <div class="dsc">{{ $list->short_desc }}</div>
                                                <div class="specification">
                                                    <ul class="list-specification">
                                                        <div class="row pl-3">
                                                            <li><i class="fa fa-taxi"></i><strong> Model </strong>{{ $list->model_name }}</li>
                                                            <li><i class="fa fa-calendar"></i><strong>Model Year </strong>{{ $list->year }}</li>
                                                            <li><i class="fa fa-dollar"></i><strong>Price </strong>{{ amount($list->price) }}</li>
                                                            <li><i class="fa fa-paint-brush"></i><strong>Color </strong>{{ $list->color_name }}</li>
                                                            {{-- <li><i class="fa fa-car"></i><strong>Transmission </strong>{{ $list->transmission }}</li>
                                                            <li><i class="fa fa-tag"></i><strong>Type </strong>{{ $list->type }}</li>
                                                            <li><i class="fa fa-car"></i><strong>Cylinder </strong>{{ $list->cylinder }}</li>
                                                            <li><i class="fa fa-user-o"></i><strong>Drive Train </strong>{{ $list->drive_train }}</li>
                                                            <li><i class="fa fa-address-card"></i><strong>VIN Number </strong>{{ $list->vin_number }}</li>
                                                            <li><i class="fa fa-road"></i><strong>ODO Meter Reading </strong>{{ $list->odo }}</li> --}}
                                                        </div>
                                                    </ul>
                                                </div>

                                                <div class="listing-bottom">
                                                    <div class="d-flex justify-content-between">
                                                        <div>City : {{$list->city_name}}</div>
                                                        <div>View : {{$list->total_views}}</div>
                                                        <div>Post Date : {{ date_full($list->created_at) }}</div>
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
    $(function() {
        var auto_models = @json($auto_models);
        var selected_job_role_id = $("#input-auto_makes").val();
        var selected_model =  '{{ old_get("auto_models") }}';

        var optarray = auto_models.map(function(k, j) {
            return {
                "value": k.auto_make_id,
                "option": "<option value='" + k.id + "'>" + k.model_name + "</option>"
            }
        })


        $("#input-auto_makes").on('change', function() {
            $("#input-auto_models").children('option').remove();
            var addoptarr = [];
            for (i = 0; i < optarray.length; i++) {
                if (optarray[i].value == $(this).val()) {
                    addoptarr.push(optarray[i].option);
                }
            }
            // append object at start of array
            addoptarr.unshift('<option value="">Select Model</option>');

            $("#input-auto_models").html(addoptarr.join(''))
        });

        if(selected_model) {
            $("#input-auto_makes").change();
            $("#input-auto_models").val(selected_model);
        }
    })
</script>
<style>
    .color_select input[type=checkbox] {
    display: none;
    }
    input[type=checkbox]:checked + label span {
    transform: scale(1.25);
    border: 2px solid #000;
    }
    .color_select label {
    display: inline-block;
    width: 25px;
    height: 25px;
    margin-right: 10px;
    cursor: pointer;
    }
    .color_select label:hover span {
    transform: scale(1.25);
    }
    .color_select label span {
    display: block;
    width: 100%;
    height: 100%;
    transition: transform 0.2s ease-in-out;
    }

    .card-heading-title > a:before {
        float: right !important;
        font-family: FontAwesome;
        content:"\f068";
        padding-right: 5px;
    }
    .card-heading-title > a.collapsed:before {
        float: right !important;
        content:"\f067";
    }

</style>

@endsection