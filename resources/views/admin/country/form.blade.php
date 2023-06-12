@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Country</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('country.submit',[$country->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Country Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $country->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Short Code</label>
                    <input type="text" name="code" class="form-control" value="{{ $country->code }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Color</label>
                    <input type="color" name="color" class="form-control w-9" value="{{ $country->color }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label class="control-label">Image</label>
                    <div>
                      <input type="file" name="image" accept="image/png, image/jpg, image/jpeg">
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $country->image_url }}" height="100" width="auto">
                </div>
              </div>

                          <?php
$metainfo = $country;

$metainfo->meta_description = $country->c_meta_description;
$metainfo->meta_title = $country->c_meta_title;
$metainfo->meta_keywords = $country->c_meta_keywords;
$meta_page_name = 'country';
?> @include('layouts.admin_meta')


            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('country.index') }}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save country</button>
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