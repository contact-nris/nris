@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">National batch</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('national_batches.submit',[$batch->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">National batch Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Title</label>
                    <input type="text" name="title" autofocus="" class="form-control" value="{{ $batch->title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Category</label>
                    <select type="text" name="category" class="form-control">
                      <option value="">Choose State</option> <?php foreach (\App\BatchCategory::all() as $key => $cate) {?> <option <?=$cate->id == $batch->category ? 'selected' : ''?> value="
													<?=$cate->id?>"> <?=$cate->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Details</label>
                <textarea type="text" name="details" class="summernote form-control">{{ $batch->details }}</textarea>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Expire Date</label>
                    <input type="text" id="expdate" name="expdate" class="form-control" value="{{ format_dp($batch->expdate) }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$batch->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$batch->status == '1' ? 'selected' : ''?> value="1">Active </option>
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
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ isset($batch->image_url) ? $batch->image_url : '' }}" a="{{$batch->image_url}}" height="100" width="auto">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('national_batches.index') }}" class="btn btn-link">Cancel</a>
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
  apply_dp("#expdate")
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