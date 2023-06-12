@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Electronics Classifieds View</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($electronics->images[0])) {?>
                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url('{{ $electronics->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $electronics->title }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $electronics->message !!}</div>
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
                                <td><?php echo ucwords($electronics->title); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Category</th>
                                <td><?php echo ucwords($electronics->category_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Name</th>
                                <td><?php echo ucwords($electronics->contact_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><a class="call_link"
                                        href="tel:<?php echo $electronics->contact_number; ?>"><?php echo ucwords($electronics->contact_number); ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo strtolower($electronics->contact_email); ?> </td>
                            </tr>
                            <tr>
                                <th>Display Email?</th>
                                <td><?php if ($electronics->show_email == 'Yes') {echo "Yes";} else {echo "No";}?>
                                </td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo ucwords($electronics->city); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Expiry Date</th>
                                <td><?php echo date("d M, Y", strtotime($electronics->end_date)); ?> </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <?php
$pay_data = [
	'user' => ucwords($electronics->first_name) . '&nbsp;' . ucwords($electronics->last_name),
	'txt_id' => $electronics->txn_id,
	'payer_email' => $electronics->payer_email,
	'amount' => '$' . $electronics->amount,
	'currency' => $electronics->currency,
	'payer_status' => $electronics->payer_status,
	'pay_status' => $electronics->payment_status,
	'create_at' => $electronics->created_at,
];
?>
                @if ($electronics->isPayed == 'Y' && $electronics->payment_id !== '')
                @include('admin.payment_details',$pay_data)
                @endif
            </div>
        </div>
    </div>
</div>

@endsection