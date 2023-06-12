@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Education & Teaching List</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($educationTeaching->images[0])) {?>
                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url('{{ $educationTeaching->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $educationTeaching->title }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $educationTeaching->message !!}</div>
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
                                <td><?php echo ucwords($educationTeaching->title); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Category</th>
                                <td><?php echo ucwords($educationTeaching->category); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Name</th>
                                <td><?php echo ucwords($educationTeaching->contact_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><a class="call_link"
                                        href="tel:<?php echo $educationTeaching->contact_number; ?>"><?php echo ucwords($educationTeaching->contact_number); ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo strtolower($educationTeaching->contact_email); ?> </td>
                            </tr>
                            <tr>
                                <th>Display Email?</th>
                                <td><?php if ($educationTeaching->show_email == 'Yes') {echo "Yes";} else {echo "No";}?>
                                </td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo ucwords($educationTeaching->city); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Expiry Date</th>
                                <td><?php echo date("d M, Y", strtotime($educationTeaching->end_date)); ?> </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <?php
$pay_data = [
	'user' => ucwords($educationTeaching->first_name) . '&nbsp;' . ucwords($educationTeaching->last_name),
	'txt_id' => $educationTeaching->txn_id,
	'payer_email' => $educationTeaching->payer_email,
	'amount' => '$' . $educationTeaching->amount,
	'currency' => $educationTeaching->currency,
	'payer_status' => $educationTeaching->payer_status,
	'pay_status' => $educationTeaching->payment_status,
	'create_at' => $educationTeaching->created_at,
];
?>
                @if ($educationTeaching->isPayed == 'Y' && $educationTeaching->payment_id !== '')
                @include('admin.payment_details',$pay_data)
                @endif
            </div>
        </div>
    </div>
</div>

@endsection