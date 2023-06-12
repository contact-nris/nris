@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Auto Model</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form action="{{ route('automodel.submit',[$automodel->id]) }}" method="post" id="form">
                        <div class="card-header">
                            <h3 class="card-title">Auto Model Details</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" name="model_name" autofocus="" class="form-control" value="{{ $automodel->model_name }}">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Auto Make</label>
                                <select type="text" name="auto_make_id"class="form-control">
                                    <option value="">Filter By Auto Makes</option>
                                    <?php foreach (\App\AutoMake::all() as $key => $make) {?>
                                        <option <?=$make->id == $automodel->auto_make_id ? 'selected' : ''?> value="<?=$make->id?>"><?=$make->name?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex">
                                <a href="{{ route('automodel.index') }}" class="btn btn-link">Cancel</a>
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
