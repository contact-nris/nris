@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Forum Thread</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('forum.submit',[$forum->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Forum Thread Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Title</label>
                    <input type="text" name="title" autofocus="" class="form-control" value="{{ $forum->title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$forum->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$forum->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Description</label>
                <textarea name="description" class="summernote form-control">{{ $forum->description }}</textarea>
              </div>

                            <?php $metainfo = $forum;
$meta_page_name = 'forum';
?> @include('layouts.admin_meta')


            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('forum.index') }}" class="btn btn-link">Cancel</a>
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