@extends('layouts.front',$meta_tags)

@section('content')
    <div class="container m-t-124">
        <div class="row">
            @include('front.profile.header')

            <div class="col-sm-12 mt-4">
                <div class="card">
                    <form action="{{ route('front.profile_submit') }}" method="post" id="form">
                        @csrf
                        <div class="card-body profile-edit p-3">
                            <h2 class="card-title mb-3">Edit Profile</h2>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="control-label mb-1">First Name</label>
                                        <input type="text" name="first_name" autofocus="" class="form-control"
                                            value="{{ $user->first_name }}">
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ $user->last_name }}">
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Email</label>
                                        <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Mobile</label>
                                        <input type="text" name="mobile" class="form-control"
                                            value="{{ $user->mobile }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label">Date of birth</label>
                                <input type="text" id="dob" name="dob" class="form-control"
                                    value="{{ format_dp($user->dob ? $user->dob : '', 'front') }}">
                            </div>



                            <div class="form-group mb-3">
                                <label class="control-label">Address</label>
                                <textarea name="address" class="form-control">{{ $user->address }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label">Zip Code</label>
                                <input type="text" name="zip_code" class="form-control" value="{{ $user->zip_code }}">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="control-label">State</label>
                                        <select onchange="fillCity(this.value,'.city-container')" type="text" name="state"
                                            class="form-control">
                                            <option value="">Choose State</option>
                                            <?php foreach (states(true) as $key => $state) {?>
                                            <option <?=$state->code == $user->state ? 'selected' : ''?>
                                                value="<?=$state->code?>"><?=$state->name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="control-label">City</label>
                                        <select type="text" name="city" class="form-control city-container">
                                            <option value="">Choose City</option>
                                        </select>
                                        <script type="text/javascript">
                                            fillCity("<?=$user->state?>", ".city-container", "<?=(int) $user->city?>")
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Profile Image</label>
                                <input name="image" class="form-control" type="file">
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('front.profile') }}" type="button" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-submit btn-success ml-auto">Save profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        apply_dp("#dob");

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
