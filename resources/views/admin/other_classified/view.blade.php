@extends('layouts.admin')

@section('content')
    <div class="my-md-5 my-3">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Other Classifieds Classifieds View</h1>
                <div class="page-options">

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <?php if (isset($other->images[0])) {?>
                        <div class="card-img-top img-responsive img-responsive-16by9"
                            style="background-image: url('{{ $other->images[0] }}')"></div>
                        <?php }?>

                        <div class="card-body">
                            <h3 class="card-title text-primary">{{ $other->title }}</h3>
                            <div class="mt-0">
                                <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                                <div class="desc">{!! $other->message !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="bg-white">
                        <table class="table-detail table-bordered table-sm table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <td><?php echo ucwords($other->title); ?> </td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo ucwords($other->address); ?> </td>
                                </tr>
                                <tr>
                                    <th>Contact Name</th>
                                    <td><?php echo ucwords($other->contact_name); ?> </td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td><a class="call_link" href="tel:<?php echo $other->contact_number; ?>"><?php echo ucwords($other->contact_number); ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo strtolower($other->contact_email); ?> </td>
                                </tr>
                                <tr>
                                    <th>Display Email?</th>
                                    <td><?php if ($other->show_email == 'Yes') {
	echo 'Yes';
} else {
	echo 'No';
}?> </td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo ucwords($other->states_name); ?> </td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?php echo ucwords($other->city_name); ?> </td>
                                </tr>
                                <tr>
                                    <th>Ad Expiry Date</th>
                                    <td><?php echo date('d M, Y', strtotime($other->end_date)); ?> </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <?php
$pay_data = [
	'user' => ucwords($other->first_name) . '&nbsp;' . ucwords($other->last_name),
	'txt_id' => $other->txn_id,
	'payer_email' => $other->payer_email,
	'amount' => '$' . $other->amount,
	'currency' => $other->currency,
	'payer_status' => $other->payer_status,
	'pay_status' => $other->payment_status,
	'create_at' => $other->created_at,
];
?>
                    @if ($other->isPayed == 'Y' && $other->payment_id !== '')
                        @include('admin.payment_details',$pay_data)
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
