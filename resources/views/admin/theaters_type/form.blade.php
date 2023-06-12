@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Theaters Type</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('theaters_type.submit',[$theaters_type->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Theaters Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $theaters_type->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">color</label>
                    <input type="color" name="color" autofocus="" class="form-control w-8" value="{{ $theaters_type->color ? $theaters_type->color : '#ff0000' }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('theaters_type.index') }}" class="btn btn-link">Cancel</a>
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