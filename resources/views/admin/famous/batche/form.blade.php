@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Famous Batche</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('famous_batche.submit',[$batche->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Famous Batche Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $batche->title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Batche Type</label>
                    <select type="text" name="batche_type" class="form-control">
                      <option value="">Choose Type</option> <?php foreach ($types as $key => $type) {?> <option <?=$type->id == $batche->category ? 'selected' : ''?> value="
                                                    <?=$type->id?>"> <?=$type->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Enter Content</label>
                    <textarea name="details" class="form-control">{{ $batche->details }}</textarea>
                  </div>
                </div>
              </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label class="control-label">E-mail</label>
                        <input type="text" name="email_id" class="form-control" value="{{ $batche->email_id }}">
                      </div>
                    </div>

                  <div class="col">
                    <div class="form-group">
                      <label class="control-label">Status</label>
                      <select type="text" name="status" class="form-control">
                        <option value="">Choose Status</option>
                        <option <?=$batche->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                        <option <?=$batche->status == '1' ? 'selected' : ''?> value="1">Active </option>
                      </select>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label class="control-label">Other Details</label>
                      <textarea name="other_details" class="form-control">{{ $batche->other_details }}</textarea>
                    </div>
                  </div>
                </div>
                     <?php $metainfo = $batche;
$meta_page_name = 'Batche';
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
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $batche->image_url }}" height="50" width="auto">
                </div>
              </div>
            </div>
            <div class="card-body"> @include('admin.common/business_hour', array( 'model' => 'f_batche', 'model_id' => (int)$batche->id )) </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('famous_batche.index') }}" class="btn btn-link">Cancel</a>
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
  apply_dp("#sdate");
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