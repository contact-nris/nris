@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Free Stuff Classifieds View</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($stuff->images[0])) {?>
                        <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url('{{ $stuff->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $stuff->title }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $stuff->message !!}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="bg-white">
                    <table class="table table-detail table-bordered table-sm ">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <td><?php echo ucwords($stuff->title); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Name</th>
                                <td><?php echo ucwords($stuff->contact_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><a class="call_link" href="tel:<?php echo $stuff->contact_number; ?>"><?php echo ucwords($stuff->contact_number); ?></a></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo strtolower($stuff->contact_email); ?> </td>
                            </tr>
                            <tr>
                                <th>Display Email?</th>
                                <td><?php if ($stuff->show_email == 'Yes') {echo "Yes";} else {echo "No";}?> </td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo ucwords($stuff->city_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Expiry Date</th>
                                <td><?php echo date("d M, Y", strtotime($stuff->end_date)); ?> </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <?php
$pay_data = [
	'user' => ucwords($stuff->first_name) . '&nbsp;' . ucwords($stuff->last_name),
	'txt_id' => $stuff->txn_id,
	'payer_email' => $stuff->payer_email,
	'amount' => '$' . $stuff->amount,
	'currency' => $stuff->currency,
	'payer_status' => $stuff->payer_status,
	'pay_status' => $stuff->payment_status,
	'create_at' => $stuff->created_at,
];
?>
                    @if ($stuff->isPayed == 'Y' && $stuff->payment_id !== '')
                        @include('admin.payment_details',$pay_data)
                    @endif
            </div>
        </div>
    </div>
</div>

@endsection
