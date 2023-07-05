@extends('layouts.admin') @section('content') <div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Blog</h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <form action="{{ route('blog.submit',[$blog->id]) }}" method="post" id="form">
            <div class="card-header">
              <h3 class="card-title">Blog Details</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Blog Title</label>
                    <input type="text" name="title" autofocus="" class="form-control" value="{{ $blog->title }}" require>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Blog URL</label>
                    <input type="text" name="url" autofocus="" class="form-control" value="{{ $blog->url }}" require>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Description</label>
                <textarea name="description" class="summernote form-control">{{ $blog->description }}</textarea>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Category</label>
                    <select type="text" name="category_id" class="form-control" required>
                      <option value="">Select Category</option> <?php foreach (\App\BlogCategory::all() as $key => $cate) {?> <option <?=$cate->id == $blog->category_id ? 'selected' : ''?> value="
														<?=$cate->id?>"> <?=$cate->name?> </option> <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Visibility</label>
                    <select type="text" name="visibility" class="form-control">
                      <option value="">Choose Visibility</option>
                      <option <?=$blog->visibility == 'Public' ? 'selected' : ''?> value="Public">Public </option>
                      <option <?=$blog->visibility == 'Private' ? 'selected' : ''?> value="Private">Private </option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select type="text" name="status" class="form-control">
                      <option value="">Choose Status</option>
                      <option <?=$blog->status == '0' ? 'selected' : ''?> value="0">InActive </option>
                      <option <?=$blog->status == '1' ? 'selected' : ''?> value="1">Active </option>
                    </select>
                  </div>
                </div>
              </div>
                  <?php $metainfo = $blog;
$meta_page_name = 'Blog';
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
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{$blog->image_url}}" height="50" width="auto">
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="{{ route('blog.index') }}" class="btn btn-link">Cancel</a>
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