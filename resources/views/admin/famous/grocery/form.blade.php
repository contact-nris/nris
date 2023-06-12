@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Famous Grocery</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('famous_grocery.submit',[$grocery->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Famous Grocery Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="search" name="name" autofocus="" class="form-control" value="{{ $grocery->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="text" name="email_id" class="form-control" value="{{ $grocery->email_id }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Grocery URL (If any)</label>
                    <input type="text" name="url" class="form-control" value="{{ $grocery->url }}">
                  </div>
                </div>
                </div>


              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State</label>
                    <select onchange="fillCity(this.value,'.city-container')" type="text" name="state_code" class="form-control">
                      <option value="">Choose State</option> <?php foreach (states() as $key => $state) {?> <option <?=$state->code == $grocery->state_code ? 'selected' : ''?> value="
                                                        <?=$state->code?>"> <?=$state->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">City</label>
                    <select type="text" name="city_id" class="form-control city-container"><?php if ($grocery->city_id) {
	echo ' <option value="' . $grocery->city_id . '">' . get_city($grocery->city_id) . '</option>';
} else {?>
                      <option value="">Choose City</option>
                      <?php }?></select>
                    <script type="text/javascript">
                      fillCity(' < ? = $grocery - > state_code ? > ','.city - container ', < ? = (int) $grocery - > city_id ? > )
                    </script>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$grocery->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$grocery->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
                 </div>

                <div class="row">
                  <div class="col">
                  <div class="form-group">
                    <label class="control-label">Grocery Address</label>
                    <textarea name="address" class="form-control">{{ $grocery->address }}</textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Other Details</label>
                    <textarea name="other_details" class="form-control">{{ $grocery->other_details }}</textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Grocery Contact No</label>
                    <input type="text" name="contact" class="form-control" value="{{ $grocery->contact }}">
                  </div>
                </div>
              </div>
                     <?php $metainfo = $grocery;
$meta_page_name = 'Gyrocery';
?> @include('layouts.admin_meta')

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
                     <!---->
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"   src="{{ $grocery->image_url }}" u="{{    str_replace('sumd2014/upload/groceries/','upload/groceries/',$grocery->image_url ) }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-body"> @include('admin.common/business_hour', array( 'model' => 'f_grocery', 'model_id' => (int)$grocery->id )) </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('famous_grocery.index') }}" class="btn btn-link">Cancel</a>
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