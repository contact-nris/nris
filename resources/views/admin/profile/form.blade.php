@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">User Profile</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('profilesetting.submit',[$profile->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">User Details</h3>
            </div>
                <div class="card-body">
                    <div class="row">
                         <div class="col">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" autofocus="" class="form-control" value="{{ $profile->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" name="email" class="form-control" value="{{ $profile->email }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $profile->username }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Role</label>
                    <select type="text" disabled="disabled" name="role" class="form-control">
                      <option value="">Choose Role</option>
                      <option <?=$profile->role == 'Admistrator' ? 'selected' : ''?> value="Admistrator">Admistrator</option>
                      <option <?=$profile->role == 'Director' ? 'selected' : ''?> value="Director">Director</option>
                      <option <?=$profile->role == 'Manager' ? 'selected' : ''?> value="Manager">State Manager</option>
                      <option <?=$profile->role == 'Clerk' ? 'selected' : ''?> value="Clerk">Data Entry Engineer</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Mobile</label>
                    <input type="text" name="contact_no" class="form-control" value="{{ $profile->contact_no }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('admin.index') }}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save admin</button>
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