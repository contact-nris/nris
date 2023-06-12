@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Baby Sitting List</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($babysitting->images[0])) {?>
                        <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url('{{ $babysitting->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $babysitting->title }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $babysitting->message !!}</div>
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
                                <td><?php echo ucwords($babysitting->title); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Category</th>
                                <td><?php echo ucwords($babysitting->category); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Name</th>
                                <td><?php echo ucwords($babysitting->contact_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><a class="call_link" href="tel:<?php echo $babysitting->contact_number; ?>"><?php echo ucwords($babysitting->contact_number); ?></a></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo strtolower($babysitting->contact_email); ?> </td>
                            </tr>
                            <tr>
                                <th>Display Email?</th>
                                <td><?php if ($babysitting->show_email == 'Yes') {echo "Yes";} else {echo "No";}?> </td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo ucwords($babysitting->city); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Expiry Date</th>
                                <td><?php echo date("d M, Y", strtotime($babysitting->end_date)); ?> </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <?php
$pay_data = [
	'user' => ucwords($babysitting->first_name) . '&nbsp;' . ucwords($babysitting->last_name),
	'txt_id' => $babysitting->txn_id,
	'payer_email' => $babysitting->payer_email,
	'amount' => '$' . $babysitting->amount,
	'currency' => $babysitting->currency,
	'payer_status' => $babysitting->payer_status,
	'pay_status' => $babysitting->payment_status,
	'create_at' => $babysitting->created_at,
];
?>
                    @if ($babysitting->isPayed == 'Y' && $babysitting->payment_id !== '')
                        @include('admin.payment_details',$pay_data)
                    @endif
            </div>
        </div>
    </div>
</div>

@endsection
