@extends('layouts.front', $meta_tags)

@section('content')
<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Student Talk</h2>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li class=""><a href="{{ route('adduniversity.index') }}">Student Talk /</a></li>
                            <li class="current">Add University</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-padding">

        <div class="container">

            <div class="product-info row">
                <div class="col-lg-12 col-md-12 col-xs-12">

                    <div class="card comment-card mt-3">
                        <div class="card-body">
                            <form action="{{ route('adduniversity.submit_topic') }}" method="post" id="form">
                                @csrf
                                {{-- <input type="hidden" name="state" value="{{$stu_state}}"> --}}
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-md-0 mb-3">
                                        <input type="text" name="title" placeholder="Title"
                                            class="form-control form-control-lg">
                                    </div>
                                    <div class="col-12 col-md-6 mb-md-0 mb-3">
                                        <input type="text" name="email" placeholder="E-mail"
                                            class="form-control form-control-lg">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-md-0 mb-3">
                                        <input type="mobile" name="mobile" placeholder="Mobile No"
                                            class="form-control form-control-lg">
                                    </div>
                                    <div class="col-12 col-md-6 mb-md-0 mb-3">
                                        <select class="form-control" name="topic_type">
                                            <option value="">Select Type</option>
                                            <option value="Accommodation">Accommodation</option>
                                            <option value="CampusJobs">Campus Jobs</option>
                                            <option value="AssignmentHelp">Assignment Help</option>
                                            <option value="OtherTopics">Other Topics</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-md-0 mb-3">
                                        <textarea name="address" placeholder="Address" class="form-control form-control-lg mt-3" rows="3"></textarea>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        {{-- <input type="text" name="uni_name" placeholder="University Name" class="form-control form-control-lg"> --}}
                                        <select class="form-control" name="uni_name" id="">
                                            <option value="">Select University</option>
                                            @foreach ($university as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['uni_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="topic_body" placeholder="Message" class="form-control form-control-lg mt-3" rows="3"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-common mt-3"
                                            class="btn btn-red btn-lg mt-3 pl-5 pr-5">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                    $this.find(".btn-common").btn("loading");
                },
                complete: function() {
                    $this.find(".btn-common").btn("reset");
                },
                success: function(json) {
                    json_response(json, $this);
                },
            })
            return false;
        })
    </script>
@endsection
