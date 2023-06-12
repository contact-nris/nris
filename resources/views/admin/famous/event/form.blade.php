@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Famous Events</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('famous_event.submit',[$event->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Famous Events Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Event-Title </label>
                    <input type="text" name="title" class="form-control" value="{{ $event->title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Event Address</label>
                    <textarea name="address" class="form-control">{{ $event->address }}</textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Event URL (If any)</label>
                    <input type="text" name="url" class="form-control" value="{{ $event->url }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                <div class="form-group">
                  <label class="control-label">Event Type</label>
                  <select type="text" name="event_category" class="form-control">
                    <option value="">Choose Type</option> <?php foreach ($types as $key => $type) {?> <option <?=$type->id == $event->category ? 'selected' : ''?> value="
                                                    <?=$type->id?>"> <?=$type->name?> </option> <?php }?>
                  </select>
                </div>
              </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">State</label>
                    <select onchange="fillCity(this.value,'.city-container')" type="text" name="state_code" class="form-control">
                      <option value="">Choose State</option> <?php foreach (states() as $key => $state) {?> <option <?=$state->code == $event->state_code ? 'selected' : ''?> value="
                                                        <?=$state->code?>"> <?=$state->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">City</label>
                    <select type="text" name="city_id" class="form-control city-container"><?php if ($desipage->city_id) {
	echo ' <option value="' . $desipage->city_id . '">' . get_city($desipage->city_id) . '</option>';
} else {?>
                      <option value="">Choose City</option>
                      <?php }?></select>
                    <script type="text/javascript">
                      fillCity(' < ? = $event - > state_code ? > ','.city - container ', < ? = (int) $event - > city_id ? > )
                    </script>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="text" name="email_id" class="form-control" value="{{ $event->email_id }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Start Date</label>
                    <input type="text" id="sdate" name="sdate" class="form-control" value="{{ format_dp($event->sdate) }}">
                  </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label class="control-label">End Date</label>
                      <input type="text" id="edate" name="edate" class="form-control" value="{{ format_dp($event->edate) }}">
                    </div>
                  </div>
                    </div>

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label class="control-label">Status</label>
                      <select type="text" name="status" class="form-control">
                        <option value="">Choose Status</option>
                        <option <?=$event->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                        <option <?=$event->status == '1' ? 'selected' : ''?> value="1">Active </option>
                      </select>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label class="control-label">Other Details</label>
                      <textarea name="other_details" class="form-control">{{ $event->other_details }}</textarea>
                    </div>
                  </div>
                </div>
                <?php $metainfo = $event;
$meta_page_name = 'Event';
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
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $event->image_url }}" src1="{{ $event->image_url }}" height="50" width="auto">
                </div>
              </div>
              <div class="card-body"> @include('admin.common/business_hour', array( 'model' => 'f_event', 'model_id' => (int)$event->id )) </div>
              <div class="card-footer">
                <div class="d-flex">
                  <a href="{{ route('famous_event.index') }}" class="btn btn-link">Cancel</a>
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
  apply_dp("#sdate")
  apply_dp("#edate")
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