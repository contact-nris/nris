@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">NRI Card</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('nricard.submit',[$nricard->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">NRI Card Details</h3>
            </div>
            <div class="card-body">
              <div class="form-group col-12">
                <label class="control-label">Card Number</label>
                <div class="input-group">
                  <input class="form-control" type="text" name="card_no" value="{{ $nricard->card_no }}" placeholder="card Number" aria-label="card Number" aria-describedby="genrate_code">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="genrate_code">Generate Code</button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">First Name</label>
                    <input type="text" name="fname" class="form-control" value="{{ $nricard->fname }}">
                    <input type="hidden" name="user_id" class="form-control" value="{{ $nricard->user_id }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Last Name</label>
                    <input type="text" name="lname" class="form-control" value="{{ $nricard->lname }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Date Of Birth</label>
                    <input type="text" name="dob" readonly class="form-control" placeholder="Date Of Birth" value="{{ $nricard->dob }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Email</label>
                    <input type="text" name="email" class="form-control" value="{{ $nricard->email }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ $nricard->address }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Expiry Date</label>
                    <input type="text" name="expiry_date" readonly class="form-control" placeholder="Expiry Date" value="{{ $nricard->expiry_date }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Country</label>
                    <select type="text" name="country" class="form-control">
                      <option value="">Choose Country</option> <?php foreach ($countries as $key => $country) {?> <option <?=$country->id == $nricard->country ? 'selected' : ''?> value="
																				<?=$country->id?>"> <?=$country->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Type</label>
                    <select type="text" name="card_type" class="form-control">
                      <option value="">Choose Type</option>
                      <option <?=$nricard->card_type == '1' ? 'selected' : ''?> value="1">Year </option>
                      <option <?=$nricard->card_type == '2' ? 'selected' : ''?> value="2">Lifetime </option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group col-12">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$nricard->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$nricard->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="dol-6"></div>
              <div class="form-group col-sm-6">
                <label class="control-label">Image</label>
                <div>
                  <input type="file" name="image" accept="image/*">
                  <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $nricard->image_url }}" height="60" width="auto">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('nricard.index') }}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save nricard</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  apply_dp('#form input[name="dob"]');
  apply_dp('#form input[name="expiry_date"]');
  $('#form select[name="card_type"]').change(function() {
    if ($(this).val() == '1') {
      $('#form input[name="expiry_date"]').val(moment().add(1, 'year').format('YYYY-MM-DD'));
    } else {
      $('#form input[name="expiry_date"]').val('');
    }
  });
  $('#form input[name="fname"]').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: "{{ route('user.autocomplete') }}",
        dataType: "json",
        data: {
          term: request.term
        },
        success: function(data) {
          response(data);
        }
      });
    },
    minLength: 1,
    select: function(event, ui) {
      $('#form input[name="fname"]').val(ui.item.fname);
      $('#form input[name="lname"]').val(ui.item.lname);
      $('#form input[name="email"]').val(ui.item.email);
      $('#form input[name="address"]').val(ui.item.address);
      $('#form input[name="dob"]').val(moment(ui.item.dob, 'DD-MM-YYYY').format('YYYY-MM-DD'));
      $('#form select[name="country"]').val(ui.item.country);
      $('#form input[name="image"]').val(ui.item.image);
      $('#form input[name="image_url"]').val(ui.item.image_url);
      $('#form input[name="user_id"]').val(ui.item.id);
    }
  });
  //genrate  16 digit card_no number on click of genrate_code
  $('#genrate_code').click(function() {
    $.ajax({
      url: "{{ route('nricard.genrate_code') }}",
      type: "GET",
      dataType: "json",
      success: function(json) {
        $('#form input[name="card_no"]').val(json.code);
      }
    });
  });
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