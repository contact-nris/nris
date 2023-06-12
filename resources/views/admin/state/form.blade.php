@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">State</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('state.submit',[$state->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">State Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $state->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State Code</label>
                    <input type="text" name="state_code" autofocus="" class="form-control" value="{{ $state->code }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State Domain</label>
                    <input type="text" name="state_domain" autofocus="" class="form-control" value="{{ $state->domain }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State Description</label>
                    <textarea name="description" class="form-control">{{ $state->description }}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">State Logo</label>
                    <div>
                      <input type="file" name="logo">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $state->logo_url }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">State Header Image 1</label>
                    <div>
                      <input type="file" name="header_image">
                    </div>
                    <small class="text-danger"> Height should be greater than 600px and less than 900px. <br> Width should be greater than 900px and less than 1200px. </small>
                  </div>
                </div>
                <div class="col-sm-6">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $state->header_image_url }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Upload State Header Image 2</label>
                    <div>
                      <input type="file" name="header_image2">
                    </div>
                    <small class="text-danger"> Height should be greater than 600px and less than 900px. <br> Width should be greater than 900px and less than 1200px. </small>
                  </div>
                </div>
                <div class="col-sm-6">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $state->header_image2_url }}" height="50" width="auto">
                </div>
              </div>



            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Upload State Header Image 3</label>
                    <div>
                      <input type="file" name="header_image3">
                    </div>
                    <small class="text-danger"> Height should be greater than 600px and less than 900px. <br> Width should be greater than 900px and less than 1200px. </small>
                  </div>
                </div>
                <div class="col-sm-6">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $state->header_image3_url }}" height="50" width="auto">
                </div>
              </div>
                <?php $metainfo = $state;
$meta_page_name = 'state ';
$metainfo->meta_description = $state->s_meta_description;
$metainfo->meta_title = $state->s_meta_title;
$metainfo->meta_keywords = $state->s_meta_keywords;

?> @include('layouts.admin_meta')


            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('state.index') }}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save state</button>
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