@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">GIF Advertisement</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form action="{{ route('home_advertisement.submit',[$advertisement->id]) }}" method="post" id="form">
                        <div class="card-header">
                            <h3 class="card-title">GIF Advertisement Details</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                  <div class="col">
                            <div class="form-group">
                                <label class="control-label">Ad Name</label>
                                <input type="text" name="adv_name" autofocus="" class="form-control" value="{{ $advertisement->adv_name }}">
                            </div>
                            </div>
                              <div class="col">
                            <div class="form-group">
                                <label class="control-label">Ad Conatct No</label>
                                <input type="tel" name="contact" class="form-control" value="{{ $advertisement->contact }}">
                            </div>
                                </div>
                              <div class="col">
                            <div class="form-group">
                                <label class="control-label">Ad Address</label>
                                <textarea name="address"class="form-control" >{{ $advertisement->address }}</textarea>
                            </div>
                            </div>
                            </div>

                            <!-- <div class="form-group">
                                <label class="control-label">Ads Title</label>
                                <input type="text" name="ad_title" class="form-control" value="{{ $advertisement->ad_title }}">
                            </div> -->
                            <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label class="control-label">Amount</label>
                                <input type="text" name="amount" class="form-control" value="{{ $advertisement->amount }}">
                            </div>
                                </div>
                            <div class="col">
                             <div class="form-group">
                                <label class="control-label">Ads Position </label>
                                <select type="text" name="ad_position"class="form-control">
                                    <option value="">Choose Position</option>
                                  <!--  <option <?=$advertisement->ad_position == 'Home-Top-Small' ? 'selected' : ''?> value="Home-Top-Small">Home Top Small</option>
                                    <option <?=$advertisement->ad_position == 'Home-Top-Large' ? 'selected' : ''?> value="Home-Top-Large">Home Top Large</option>
                                    <option <?=$advertisement->ad_position == 'Home-Top-Center-4' ? 'selected' : ''?> value="Home-Top-Center-4">Home Top Center (4)</option>
                                    <option <?=$advertisement->ad_position == 'Home-Right-Top-8' ? 'selected' : ''?> value="Home-Right-Top-8">Home Right-Top (8)</option>
                                    <option <?=$advertisement->ad_position == 'Home-Left-Bottom' ? 'selected' : ''?> value="Home-Left-Bottom">Home Left Bottom</option>
                                    <option <?=$advertisement->ad_position == 'Home-Right-Bottom' ? 'selected' : ''?> value="Home-Right-Bottom">Home Right Bottom</option>
                                    <option <?=$advertisement->ad_position == 'Home-Bottom-Small' ? 'selected' : ''?> value="Home-Bottom-Small">Home Bottom Small</option>
                                    <option <?=$advertisement->ad_position == 'Home-Bottom-Large' ? 'selected' : ''?> value="Home-Bottom-Large">Home Bottom Large</option>
                                    -->
                                    <option <?=$advertisement->ad_position == 'Top' ? 'selected' : ''?> value="Top">Home Top</option>
                                    <option <?=$advertisement->ad_position == 'Right' ? 'Right' : ''?> value="Right">Home Right</option>
                                    <option <?=$advertisement->ad_position == 'Left' ? 'selected' : ''?> value="Left">Home Left</option>
                                    <option <?=$advertisement->ad_position == 'State Top' ? 'selected' : ''?> value="State Top">State Top</option>
                                    <option <?=$advertisement->ad_position == 'State Right' ? 'selected' : ''?> value="State Right">State Right</option>
                                    <option <?=$advertisement->ad_position == 'State Left' ? 'selected' : ''?> value="State Left">State Left</option>
                                     <option <?=$advertisement->ad_position == 'Category Right' ? 'selected' : ''?> value="Category Right">Category Right</option>


                                </select>
                            </div>
                                </div>


                                  <div class="col">
                             <div class="form-group">
                                <label class="control-label">Choose Category </label>
                                <select type="text" name="categories_id"class="form-control">
                                    <option value="0">Choose Category</option>
                              <?php foreach ($categories as $k => $v) {?>

                                    <option <?=$v->id == $advertisement->categories_id ? 'selected' : ''?> value="<?=$v->id?>"><?=$v->name?></option>
                                   <?php }?>

                                </select>
                            </div>
                                </div>


                            <div class="col">
                            <div class="form-group">
                                <label class="control-label">Ads Position No</label>
                                <select type="text" name="ad_position_no"class="form-control">
                                    <option value="">Choose Position</option>
                                    <?php for ($i = 1; $i <= 12; $i++) {?>
                                        <option <?=$advertisement->ad_position_no == $i ? 'selected' : ''?> value="{{$i}}">{{$i}}</option>
                                    <?php }?>
                                </select>
                            </div>
                            </div>
                                    </div>
                                           <div class="row">
                                                 <div class="col">
                            <div class="form-group">
                                <label class="control-label">URL</label>
                                <input type="text" name="url" class="form-control" value="{{ $advertisement->url }}">
                            </div>
                            </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">Start Date</label>
                                        <input type="text" id="sdate" name="sdate" class="form-control" value="{{ format_dp($advertisement->sdate) }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">End Date</label>
                                        <input type="text" id="edate" name="edate" class="form-control" value="{{ format_dp($advertisement->edate) }}">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <select onchange="fillState(this.value,'.state-container')" type="text" name="country_id" class="form-control">
                                            <option value="">Choose Country</option>
                                            <?php foreach (countries() as $key => $country) {?>
                                                <option <?=$country->id == $advertisement->country_id ? 'selected' : ''?> value="<?=$country->id?>"><?=$country->name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">State</label>
                                        <select type="text" name="state_id"class="form-control state-container">
                                            <option value="">Choose State</option>
                                        </select>
                                        <script type="text/javascript">
                                            fillState('<?=$advertisement->country_id?>','.state-container',<?=(int) $advertisement->state_id?>)
                                        </script>
                                    </div>
                                </div>
                                <div class="col">
                                      <div class="form-group">
                                <label class="control-label">Status</label>
                                <select type="text" name="status"class="form-control">
                                    <option value="">Choose Status</option>
                                    <option <?=$advertisement->status == '0' ? 'selected' : ''?> value="0">InActive</option>
                                    <option <?=$advertisement->status == '1' ? 'selected' : ''?> value="1">Active</option>
                                </select>
                            </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-image">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Image</label>
                                        <div>
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ isset($advertisement->image_url) ? $advertisement->image_url : '' }}" height="100" width="auto">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex">
                                <a href="{{ route('home_advertisement.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    apply_dp("#sdate")
    apply_dp("#edate")


    $("#form").submit(function(){
        $this = $(this);
        $.ajax({
            url:$this.attr("action"),
            type:'POST',
            dataType:'json',
            data:new FormData($this[0]),
            processData: false,
            contentType: false,
            beforeSend:function(){$this.find(".btn-submit").btn("loading");},
            complete:function(){$this.find(".btn-submit").btn("reset");},
            success:function(json){
                json_response(json,$this);
            },
        })

        return false;
    })
</script>
@endsection
