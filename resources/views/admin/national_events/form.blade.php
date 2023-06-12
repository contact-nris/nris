@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">National Event</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('national_events.submit',[$event->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">National Event Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Title</label>
                    <input type="text" name="title" autofocus="" class="form-control" value="{{ $event->title }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Category</label>
                    <select type="text" name="category" class="form-control">
                      <option value="">Choose Category</option> <?php foreach (\App\EventCategory::all() as $key => $cate) {?> <option <?=$cate->id == $event->category ? 'selected' : ''?> value="
													<?=$cate->id?>"> <?=$cate->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">URL</label>
                    <input type="text" name="url" class="form-control" value="{{ $event->url }}">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Details</label>
                <textarea type="text" name="details" class="summernote form-control">{{ $event->details }}</textarea>
              </div>
              <div class="form-group">
                <label class="control-label">Address</label>
                <textarea type="text" name="address" class="form-control">{{ $event->address }}</textarea>
              </div>
              <div class="row">
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
              </div>
            </div>
             <?php $metainfo = $event;
$meta_page_name = 'Eevent';
?> @include('layouts.admin_meta')
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
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ isset($event->image_url) ? $event->image_url : '' }}" a={{$event->image_url}} height="100" width="auto">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('national_events.index') }}" class="btn btn-link">Cancel</a>
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

//   $(document).on('keydown', 'input[type="text"]', function(event) {
//   var restrictedKeys = [37, 38, 39, 40]; // Arrow keys
//   if ($.inArray(event.which, restrictedKeys) >= 0) {
//     return; // Allow arrow keys to be used for navigation
//   }
//   var regex = /^[0-9a-zA-Z\s!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]*$/; // Regular expression to match allowed characters
//   var key = String.fromCharCode(event.which); // Get the pressed key as a string
//   if (!regex.test(key)) { // If the pressed key is not an allowed character
//     event.preventDefault(); // Prevent the key from being entered in the input field
//   }
// });

	$('*').on('keyup', function() { // Listen for keyup events on all input elements
				var input = $(this).val(); // Get the current value of the input
				if(/[áéíóúñÁÉÍÓÚÑ]/.test(input)) { // Test if the input contains any Spanish letters
				//	alert('Input contains Spanish letters!'); // Show an alert if the input contains Spanish letters
				//	// Clear the input field


			title = input.replace(/[áéíóúñÁÉÍÓÚÑ]/g, ''); // Remove Spanish letters
			$(this).val(title);



				}
			});


</script> @endsection