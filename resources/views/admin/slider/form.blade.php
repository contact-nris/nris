@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Slider</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form action="{{ route('slider.submit',[$slider->id]) }}" method="post" id="form">
                        <div class="card-header">
                            <h3 class="card-title">Slider Details</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" name="name" autofocus="" class="form-control" value="{{ $slider->name }}">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-image">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Slide 1</label>
                                        <div>
                                            <input type="file" name="slide1">
                                        </div>

                                        <div>
                                            <input type="hidden" name="default_slide1" value="{{ isset($slider->slides[0]) ? $slider->slides[0] : '' }}">
                                            <?php if (isset($slider->images[1])) {?>
                                                <a href="javascript:void(0)" class="text-danger remove-slide mt-2 d-block">Delete</a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ isset($slider->images[0]) ? $slider->images[0] : '' }}" height="100" width="auto">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-image">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Slide 2</label>
                                        <div>
                                            <input type="file" name="slide2">
                                        </div>
                                        <div>
                                            <input type="hidden" name="default_slide2" value="{{ isset($slider->slides[1]) ? $slider->slides[1] : '' }}">

                                            <?php if (isset($slider->images[1])) {?>
                                                <a href="javascript:void(0)" class="text-danger remove-slide mt-2 d-block">Delete</a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ isset($slider->images[1]) ? $slider->images[1] : '' }}" height="100" width="auto">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-image">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Slide 3</label>
                                        <div>
                                            <input type="file" name="slide3">
                                        </div>
                                        <div>
                                            <input type="hidden" name="default_slide3" value="{{ isset($slider->slides[2]) ? $slider->slides[2] : '' }}">

                                            <?php if (isset($slider->images[2])) {?>
                                                <a href="javascript:void(0)" class="text-danger remove-slide mt-2 d-block">Delete</a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ isset($slider->images[2]) ? $slider->images[2] : '' }}" height="100" width="auto">
                                </div>
                            </div>
                        </div>


                        <div class="card-footer">
                            <div class="d-flex">
                                <a href="{{ route('slider.index') }}" class="btn btn-link">Cancel</a>
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
    $(".remove-slide").click(function(){
        $(this).parents('div.row-image').find('img').remove();
        $(this).parent('div').remove();
    });

    $("#form").submit(function(){
        $this = $(this);
        $.ajax({
            url:$this.attr("action"),
            type:'POST',
            dataType:'json',
            data:new FormData($this[0]),
            processData: false,
            contentType: false,
            beforeSend:function(){$this.find(".btn-submit").btn("loading");},
            complete:function(){$this.find(".btn-submit").btn("reset");},
            success:function(json){
                json_response(json,$this);
            },
        })

        return false;
    })
</script>
@endsection
