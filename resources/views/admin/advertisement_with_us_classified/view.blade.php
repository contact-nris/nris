@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Advertisement Classifieds View</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($ad->images[0])) {?>
                        <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url('{{ $ad->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $ad->business }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $ad->message !!}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="bg-white">
                    <table class="table table-detail table-bordered table-sm ">
                        <thead>
                            <tr>
                                <th>Contact Name</th>
                                <td><?php echo ucwords($ad->fname); ?> </td>
                            </tr>
                            <tr>
                                <th>EMAIL ADDRESS</th>
                                <td><?php echo ucwords($ad->email); ?> </td>
                            </tr>
                            <tr>
                                <th>WER SITE</th>
                                <td><?php echo ucwords($ad->website); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><a class="call_link" href="tel:<?php echo $ad->phone; ?>"><?php echo ucwords($ad->phone); ?></a></td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
