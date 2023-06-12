@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">User</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form action="{{ route('user.submit',[$user->id]) }}" method="post" id="form">
                        <div class="card-header">
                            <h3 class="card-title">User Details</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
            <div class="col"><div class="form-group">
                                <label class="control-label">First Name</label>
                                <input type="text" name="first_name" autofocus="" class="form-control" value="{{ $user->first_name }}">
                            </div></div>
            <div class="col"><div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                            </div>
</div>
            <div class="col"> <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
</div>
<div class="col"><div class="form-group">
                                <label class="control-label">Date of birth</label>
                                <input type="text" name="dob" class="form-control" value="{{ $user->dob }}">
                            </div>
</div>
            </div>

<div class="row">
    <div class="col"><div class="form-group">
                                <label class="control-label">Address</label>
                                <textarea name="address" class="form-control">{{ $user->address }}</textarea>
                            </div></div>

            <div class="col"><div class="form-group">
                                <label class="control-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}">
                            </div></div>










                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">State</label>
                                        <select onchange="fillCity(this.value,'.city-container')" type="text" name="state"class="form-control">
                                            <option value="">Choose State</option>
                                            <?php foreach (states(true) as $key => $state) {?>
                                                <option <?=$state->code == $user->state ? 'selected' : ''?> value="<?=$state->code?>"><?=$state->name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <select type="text" name="city"class="form-control city-container">
                                            <option value="">Choose City</option>
                                        </select>
                                        <script type="text/javascript">
                                            fillCity('<?=$user->state?>','.city-container',<?=(int) $user->city?>)
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input type="text" name="password" class="form-control" value="">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                                <a href="{{ route('user.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-submit btn-primary ml-auto">Save user</button>
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
