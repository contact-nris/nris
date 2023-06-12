@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Famous Advertisements</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('famous_advertisements.submit',[$advertisement->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Famous Advertisements Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $advertisement->adv_name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement-Title </label>
                    <input type="text" name="ad_title" class="form-control" value="{{ $advertisement->ad_title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State</label>
                    <select onchange="fillCity(this.value,'.city-container')" type="text" name="state_code" class="form-control">
                      <option value="">Choose State</option> <?php foreach (states() as $key => $state) {?> <option <?=$state->code == $advertisement->state_code ? 'selected' : ''?> value="
                                                        <?=$state->code?>"> <?=$state->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">City</label>
                    <select type="text" name="city_id" class="form-control city-container"><?php if ($advertisement->city_id) {
	echo ' <option value="' . $advertisement->city_id . '">' . get_city($advertisement->city_id) . '</option>';
} else {?>
                      <option value="">Choose City</option>
                      <?php }?></select>
                    <script type="text/javascript">
                      fillCity(' < ? = $advertisement - > state_code ? > ','.city - container ', < ? = (int) $advertisement - > city_id ? > )
                    </script>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement Amount No</label>
                    <input type="text" name="amount" class="form-control" value="{{ $advertisement->amount }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement Position</label>
                    <select type="text" name="ad_position" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$advertisement->ad_position == 'Left Side' ? 'selected' : ''?> value="Left Side">Left Side </option>
                      <option <?=$advertisement->ad_position == 'Right Side' ? 'selected' : ''?> value="Right Side">Right Side </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement Position No</label>
                    <select type="text" name="ad_position_no" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$advertisement->ad_position_no == '1' ? 'selected' : ''?> value="1">1 </option>
                      <option <?=$advertisement->ad_position_no == '2' ? 'selected' : ''?> value="2">2 </option>
                      <option <?=$advertisement->ad_position_no == '3' ? 'selected' : ''?> value="3">3 </option>
                      <option <?=$advertisement->ad_position_no == '4' ? 'selected' : ''?> value="4">4 </option>
                      <option <?=$advertisement->ad_position_no == '5' ? 'selected' : ''?> value="5">5 </option>
                      <option <?=$advertisement->ad_position_no == '6' ? 'selected' : ''?> value="6">6 </option>
                      <option <?=$advertisement->ad_position_no == '7' ? 'selected' : ''?> value="7">7 </option>
                      <option <?=$advertisement->ad_position_no == '8' ? 'selected' : ''?> value="8">8 </option>
                      <option <?=$advertisement->ad_position_no == '9' ? 'selected' : ''?> value="9">9 </option>
                      <option <?=$advertisement->ad_position_no == '10' ? 'selected' : ''?> value="10">10 </option>
                      <option <?=$advertisement->ad_position_no == '11' ? 'selected' : ''?> value="11">11 </option>
                      <option <?=$advertisement->ad_position_no == '12' ? 'selected' : ''?> value="12">12 </option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement Conatct No</label>
                    <input type="text" name="contact" class="form-control" value="{{ $advertisement->contact }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement Address</label>
                    <textarea name="address" class="form-control">{{ $advertisement->address }}</textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Advertisement URL (If any)</label>
                    <input type="text" name="url" class="form-control" value="{{ $advertisement->url }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="text" name="email_id" class="form-control" value="{{ $advertisement->email_id }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">End Date</label>
                    <input type="text" id="edate" name="edate" class="form-control" value="{{ format_dp($advertisement->edate) }}">
                  </div>
                </div>
              </div>
              <!-- </div> -->
              <!-- </div> -->
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$advertisement->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$advertisement->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Other Details</label>
                    <textarea name="other_details" class="form-control">{{ $advertisement->other_details }}</textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Image</label>
                    <div>
                      <input type="file" name="image">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $advertisement->image_url }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-body"> @include('admin.common/business_hour', array( 'model' => 'f_advertisements', 'model_id' => (int)$advertisement->id )) </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('famous_advertisements.index') }}" class="btn btn-link">Cancel</a>
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
</script> @endsection