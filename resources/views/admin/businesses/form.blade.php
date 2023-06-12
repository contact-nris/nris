@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Businesses</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('businesses.submit',[$busi->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Businesses Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Businesses Title</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $busi->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Offers</label>
                    <input type="text" name="offers" autofocus="" class="form-control" value="{{ $busi->offers }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Contact</label>
                    <input type="text" name="contact" autofocus="" class="form-control" value="{{ $busi->phone }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State</label>
                    <select onchange="fillCity(this.value,'.city-container')" type="text" name="state_code" class="form-control">
                      <option value="">Choose State</option> <?php foreach (states() as $key => $state) {?> <option <?=$state->code == $busi->state_code ? 'selected' : ''?> value="
															<?=$state->code?>"> <?=$state->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">City</label>
                    <select type="text" name="city_id" class="form-control city-container"><?php if ($temple->city_id) {
	echo ' <option value="' . $temple->city_id . '">' . get_city($temple->city_id) . '</option>';
} else {?>
                      <option value="">Choose City</option>
                      <?php }?></select>
                    <script type="text/javascript">
                      fillCity(' < ? = $busi - > state_code ? > ','.city - container ', < ? = (int) $busi - > city ? > )
                    </script>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Category</label>
                    <select type="text" name="category_id" class="form-control">
                      <option value="">Choose State</option> <?php foreach (\App\BusinessesCategory::all() as $key => $cate) {?> <option <?=$cate->id == $busi->category_id ? 'selected' : ''?> value="
															<?=$cate->id?>"> <?=$cate->cat_name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">URL</label>
                    <input type="text" name="url" class="form-control" value="{{ $busi->url }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" name="email_id" autofocus="" class="form-control" value="{{ $busi->email }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$busi->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$busi->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Address</label>
                <textarea name="address" class="form-control">{{ $busi->address }}</textarea>
              </div>
              <div class="form-group">
                <label class="control-label">Description</label>
                <textarea name="description" class="summernote form-control">{{ $busi->description }}</textarea>
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
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $busi->image_url }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('businesses.index') }}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save Data</button>
              </div>
            </div>
          </form>
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