@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Video</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('video.submit',[$video->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Video Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Video Title</label>
                    <input type="text" name="title" autofocus="" class="form-control" value="{{ $video->title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Video Link</label>
                    <input type="text" name="link" autofocus="" class="form-control" value="{{ $video->link }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Language</label>
                    <select type="text" name="language" class="form-control">
                      <option value="">Choose State</option> <?php foreach (\App\VideoLanguage::all() as $key => $lang) {?> <option <?=$lang->id == $video->language ? 'selected' : ''?> value="
														<?=$lang->id?>"> <?=$lang->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Category</label>
                    <select type="text" name="category" class="form-control">
                      <option value="">Choose State</option> <?php foreach (\App\VideoCategory::all() as $key => $cate) {?> <option <?=$cate->id == $video->category ? 'selected' : ''?> value="
														<?=$cate->id?>"> <?=$cate->category_name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$video->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$video->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('video.index') }}" class="btn btn-link">Cancel</a>
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