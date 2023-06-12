@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Room Mate Classifieds View</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($real->images[0])) {?>
                        <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url('{{ $real->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $real->title }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $real->message !!}</div>
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
                                <td><?php echo ucwords($real->title); ?> </td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td><?php echo ucwords($real->category_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Gender Preference</th>
                                <td><?php echo ucwords($real->gender_type); ?> </td>
                            </tr>
                            <tr>
                                <th>Rent</th>
                                <td><?php echo ucwords($real->rent); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Name</th>
                                <td><?php echo ucwords($real->contact_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><a class="call_link" href="tel:<?php echo $real->contact_number; ?>"><?php echo ucwords($real->contact_number); ?></a></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo strtolower($real->contact_email); ?> </td>
                            </tr>
                            <tr>
                                <th>Display Email?</th>
                                <td><?php if ($real->show_email == 'Yes') {echo "Yes";} else {echo "No";}?> </td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo ucwords($real->city_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Ad Expiry Date</th>
                                <td><?php echo date("d M, Y", strtotime($real->end_date)); ?> </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <?php
$pay_data = [
	'user' => ucwords($real->first_name) . '&nbsp;' . ucwords($real->last_name),
	'txt_id' => $real->txn_id,
	'payer_email' => $real->payer_email,
	'amount' => '$' . $real->amount,
	'currency' => $real->currency,
	'payer_status' => $real->payer_status,
	'pay_status' => $real->payment_status,
	'create_at' => $real->created_at,
];
?>
                    @if ($real->isPayed == 'Y' && $real->payment_id !== '')
                        @include('admin.payment_details',$pay_data)
                    @endif
            </div>
        </div>
    </div>
</div>

@endsection
