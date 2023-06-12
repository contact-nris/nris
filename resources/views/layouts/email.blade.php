r@extends('layouts.front')

@section('content')

<div class="page-header" style="background: url(assets/img/banner1.jpg); margin-top: 80px;">
        <div class="container m-t-124">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Mail Tester</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home /</a></li>
                        <li class="current">Mail Tester</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding mt-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">PHPMailer Example </h4>
                    </div>
                    <form method="post" action="{{ route('send-email') }}" enctype="multipart/form-data" id="form">
                        <div class="card-body text-black">
                            @csrf
                            <div class="form-group">
                                <label for="emailRecipient">Email To </label>
                                <input type="email" name="emailRecipient" id="emailRecipient" class="form-control" placeholder="Mail To">
                            </div>

                            <div class="form-group">
                                <label for="emailCc">CC </label>
                                <input type="email" name="emailCc" id="emailCc" class="form-control" placeholder="Mail CC">
                            </div>

                            <div class="form-group">
                                <label for="emailBcc">BCC </label>
                                <input type="email" name="emailBcc" id="emailBcc" class="form-control" placeholder="Mail BCC">
                            </div>

                            <div class="form-group">
                                <label for="emailSubject">Subject </label>
                                <input type="text" name="emailSubject" id="emailSubject" class="form-control" placeholder="Mail Subject">
                            </div>

                            <div class="form-group">
                                <label for="emailBody">Message </label>
                                <textarea name="emailBody" id="emailBody" class="form-control" placeholder="Mail Body"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="emailAttachments">Attachment(s) </label>
                                <input type="file" name="emailAttachments[]" multiple="multiple" id="emailAttachments" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success btn-submit">Save Ad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
            }
        })

        return false;
    })
</script>
@endsection