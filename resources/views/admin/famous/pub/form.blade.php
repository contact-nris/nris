@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Famous Pub</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('famous_pubs.submit',[$pub->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Famous Pub Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $pub->pub_name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="text" name="email_id" class="form-control" value="{{ $pub->email_id }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Pub Type</label>
                    <select type="text" name="pub_type" class="form-control">
                      <option value="">Choose Type</option> <?php foreach ($types as $key => $type) {?> <option <?=$type->id == $pub->pub_type ? 'selected' : ''?> value="
                                                    <?=$type->id?>"> <?=$type->type?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State</label>
                    <select onchange="fillCity(this.value,'.city-container')" type="text" name="state_code" class="form-control">
                      <option value="">Choose State</option> <?php foreach (states() as $key => $state) {?> <option <?=$state->code == $pub->state_code ? 'selected' : ''?> value="
                                                        <?=$state->code?>"> <?=$state->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">City</label>
                    <select type="text" name="city_id" class="form-control city-container"><?php if ($pub->city_id) {
	echo ' <option value="' . $pub->city_id . '">' . get_city($pub->city_id) . '</option>';
} else {?>
                      <option value="">Choose City</option>
                      <?php }?></select>
                    <script type="text/javascript">
                      fillCity(' < ? = $pub - > state_code ? > ','.city - container ', < ? = (int) $pub - > city_id ? > )
                    </script>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$pub->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$pub->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Pub Address</label>
                    <textarea name="address" class="form-control">{{ $pub->address }}</textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Pub Conatct No</label>
                    <input type="text" name="contact" class="form-control" value="{{ $pub->contact }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Pub URL (If any)</label>
                    <input type="text" name="url" class="form-control" value="{{ $pub->url }}">
                  </div>
                </div>
              </div>


              <!-- <div class="row">-->
              <!--  <div class="col">-->
              <!--    <div class="form-group">-->
              <!--      <label class="control-label">Pub Meta Address</label>-->
              <!--      <textarea name="meta_title" required class="form-control" maxlength="60">{{ $pub->meta_title }}</textarea>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--  <div class="col">-->
              <!--    <div class="form-group">-->
              <!--      <label class="control-label">Pub Meta Conatct No</label>-->
              <!--  <textarea name="meta_description" required class="form-control" maxlength="160">{{  $pub->meta_description }}</textarea>-->
              <!--    </div>-->
              <!--  </div>  -->
              <!--  <div class="col">-->
              <!--    <div class="form-group">-->
              <!--      <label class="control-label">Pub Meta Keywords</label>-->
              <!--    <textarea name="meta_keywords" required class="form-control" maxlength="10">{{ $pub->meta_keywords }}</textarea>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <?php $metainfo = $pub;
$meta_page_name = 'Pub';

?>

                         @include('layouts.admin_meta')

              <div class="row">
              <div class="col">
                  <div class="form-group">
                    <label class="control-label">Other Details</label>
                    <textarea name="other_details" class="form-control">{{ $pub->other_details }}</textarea>
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
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $pub->image_url }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-body"> @include('admin.common/business_hour', array( 'model' => 'f_pubs', 'model_id' => (int)$pub->id )) </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('famous_pubs.index') }}" class="btn btn-link">Cancel</a>
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