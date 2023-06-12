@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Movie External Rating</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('movies_external_rating.form',[$rating->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Movie External Rating Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Movie Title</label>
                    <input type="text" name="movie_name" autofocus="" class="form-control" value="{{ $rating->movie_name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$rating->status == 'InActive' ? 'selected' : ''?> value="InActive">InActive </option>
                      <option <?=$rating->status == 'Active' ? 'selected' : ''?> value="Active">Active </option>
                    </select>
                  </div>
                </div>
              </div>
            </div> <?php foreach ($sources as $key => $source) {?> <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label class="control-label"> <?php echo $source->source_name; ?> Rating </label>
                    <select class="form-control" name="rating_data[{{$source->id}}][0]">
                      <option value="">- Select Rating -</option>
                      <option value="1" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '1' ? 'selected="selected"' : ''; ?>>1 </option>
                      <option value="2" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '2' ? 'selected="selected"' : ''; ?>>2 </option>
                      <option value="2.5" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '2.5' ? 'selected="selected"' : ''; ?>>2.5 </option>
                      <option value="2.75" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '2.75' ? 'selected="selected"' : ''; ?>>2.75 </option>
                      <option value="3" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '3' ? 'selected="selected"' : ''; ?>>3 </option>
                      <option value="3.25" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '3.25' ? 'selected="selected"' : ''; ?>>3.25 </option>
                      <option value="3.5" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '3.5' ? 'selected="selected"' : ''; ?>>3.5 </option>
                      <option value="3.75" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '3.75' ? 'selected="selected"' : ''; ?>>3.75 </option>
                      <option value="4" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '4' ? 'selected="selected"' : ''; ?>>4 </option>
                      <option value="4.25" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '4.25' ? 'selected="selected"' : ''; ?>>4.25 </option>
                      <option value="4.5" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '4.5' ? 'selected="selected"' : ''; ?>>4.5 </option>
                      <option value="4.75" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '4.75' ? 'selected="selected"' : ''; ?>>4.75 </option>
                      <option value="5" <?php echo isset($rating->rating_data[$source->id]) && $rating->rating_data[$source->id][0] == '5' ? 'selected="selected"' : ''; ?>>5 </option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label"> <?php echo $source->source_name; ?> URL </label>
                    <input type="text" name="rating_data[{{$source->id}}][1]" class="form-control" value="
												<?php echo isset($rating->rating_data[$source->id]) ? $rating->rating_data[$source->id][1] : ''; ?>" />
                  </div>
                </div>
              </div>
            </div> <?php }?> <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('movies_external_rating.index') }}" class="btn btn-link">Cancel</a>
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