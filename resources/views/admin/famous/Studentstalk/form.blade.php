@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Famous Student's Talk</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('famous_studenttal.submit', [$students_talk->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Famous Student's Talk Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $students_talk->uni_name }}">
                  </div>
                </div>
                <div class="col">
                <div class="form-group">
                  <label class="control-label">E-mail</label>
                  <input type="text" name="email_id" class="form-control" value="{{ $students_talk->email_id }}">
                </div>
              </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Field of Education</label>
                    <input type="text" name="edu_name" autofocus="" class="form-control" value="{{ $students_talk->edu_field }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State</label>
                    <select onchange="fillCity(this.value,'.city-container')" type="text" name="state_code" class="form-control">
                      <option value="">Choose State</option> <?php foreach (states() as $key => $state) {?> <option <?=$state->code == $students_talk->state_code ? 'selected' : ''?> value="
                                                        <?=$state->code?>"> <?=$state->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
              <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$students_talk->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$students_talk->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              <div class="col">
                <div class="form-group">
                  <label class="control-label">Url</label>
                  <input type="text" name="url" class="form-control" value="{{ $students_talk->url }}">
                </div>
              </div>
               </div>
                        <?php $metainfo = $students_talk;
$meta_page_name = 'Students talk';
?> @include('layouts.admin_meta')
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Description</label>
                    <textarea name="details" class="form-control">{{ $students_talk->details }}</textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Other Details</label>
                    <textarea name="other_details" class="form-control">{{ $students_talk->other_details }}</textarea>
                  </div>
                </div>
              </div>

            <div class="card-body"> @include('admin.common/business_hour', array( 'model' => 'f_studenttalk', 'model_id' => (int)$students_talk->id )) </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('famous_studenttal.index') }}" class="btn btn-link">Cancel</a>
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