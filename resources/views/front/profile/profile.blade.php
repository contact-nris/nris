@extends('layouts.front',$meta_tags)

@section('content')
    <div class="container m-t-124">
        <div class="row">
            @include('front.profile.header')

            <div class="col-sm-12 mt-4">
                <div class="bg-white">
                    <div class="profile-info">
                        <h5 class="mb-0">Name: <span>{{ $user->first_name }} {{ $user->last_name }}</span></h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">Mobile Number: <span>{{ na($user->mobile) }}</span></h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">Email: <span>{{ na($user->email) }}</span></h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">Date of birth: <span>{{ na($user->dob) }}</span></h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">Address: <span>{{ na($user->address) }}</span></h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">State: <span>{{ na($user->state) }}</span></h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">City: <span>{{ $user->cityname ? $user->cityname->name : 'NA' }}</span>
                        </h5>
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-0">Zip: <span>{{ na($user->zip_code) }}</span></h5>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
