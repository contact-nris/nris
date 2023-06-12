@extends('layouts.front',$meta_tags)

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Create Topic</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li><a href="{{ route('front.forum_subcate', $sub_category_id) }}">{{ $parentCategory->name }} /</a></li>
                        <li class="current">Create Topic</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Create Topic</h3>
                    </div>
                    <form method="post" action="{{ route('front.forum.submit', ) }}" enctype="multipart/form-data" id="form">
                        <div class="card-body text-black">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-title" class="control-label">Title</label>
                                    <input type="text" class="form-control" id="input-title" name="title" placeholder="Enter title here">
                                    <input type="hidden" name="sub_category_id" value="{{ $sub_category_id }}">
                                    <span class="form-text text-muted">Only alphabets, numbers and spaces are allowed</span>
                                </div>

                                <div class="col-md-12 col-sm-12 form-group required">
                                    <label for="input-description" class="control-label">Description</label>
                                    <textarea class="form-control" id="input-description" name="description" rows="3" placeholder="Enter description here"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">Save Topic</button>
                            <a href="{{ route('front.forum_subcate', $sub_category_id )}} " class="btn btn-primary">Cancel</a>
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
</script>
@endsection