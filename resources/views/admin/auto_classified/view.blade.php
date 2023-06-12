@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Auto Classified List</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <?php if (isset($auto_classifieds->images[0])) {?>
                    <div class="card-img-top img-responsive img-responsive-16by9"
                        style="background-image: url('{{ $auto_classifieds->images[0] }}')"></div>
                    <?php }?>

                    <div class="card-body">
                        <h3 class="card-title text-primary">{{ $auto_classifieds->title }}</h3>
                        <div class="mt-0 ">
                            <div><small><b><i><u>DESCRIPTION</u></i></b></small></div>
                            <div class="desc">{!! $auto_classifieds->message !!}</div>
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
                                <td><?php echo ucwords($auto_classifieds->title); ?> </td>
                            </tr>
                            <tr>
                                <th>Make</th>
                                <td><?php echo ucwords($auto_classifieds->auto_makes_name); ?> </td>
                            </tr>
                            <tr>
                                <th>SubBrand</th>
                                <td><?php echo ucwords($auto_classifieds->model_name); ?> </td>
                            </tr>
                            <tr>
                                <th>Condition</th>
                                <td><?php echo ucwords($auto_classifieds->auto_condition); ?> </td>
                            </tr>
                            <tr>
                                <th>Transmission</th>
                                <td><?php echo ucwords($auto_classifieds->transmission); ?> </td>
                            </tr>
                            <tr>
                                <th>Cylinder</th>
                                <td><?php echo ucwords($auto_classifieds->cylinder); ?> </td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?php echo ucwords($auto_classifieds->type); ?> </td>
                            </tr>
                            <tr>
                                <th>Drive Train</th>
                                <td><?php echo ucwords($auto_classifieds->drive_train); ?> </td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td><?php echo ucwords($auto_classifieds->year); ?> </td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>

                                    <label class="colorbox" style="background-color:{{$auto_classifieds->color}} ;">
                                        &nbsp;
                                    </label>
                                    <?php echo $auto_classifieds->color; ?>
                </div>
                </td>
                </tr>
                <tr>
                    <th>VIN Number</th>
                    <td><?php echo ucwords($auto_classifieds->vin_number); ?> </td>
                </tr>
                <tr>
                    <th>ODO Meter Reading</th>
                    <td><?php echo ucwords($auto_classifieds->odo); ?> </td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><?php echo $auto_classifieds->price; ?> </td>
                </tr>
                <tr>
                    <th>Current MPG</th>
                    <td><?php echo $auto_classifieds->mpg; ?> </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo ucwords($auto_classifieds->address); ?> </td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $auto_classifieds->states_name }}</th>
                </tr>
                <tr>
                    <th>City</th>
                    <td><?php echo ucwords($auto_classifieds->city_name); ?> </td>
                </tr>

                <tr>
                    <th>URL</th>
                    <td><?php echo strtolower($auto_classifieds->url); ?> </td>
                </tr>
                <tr>
                    <th>Contact Name</th>
                    <td><?php echo ucwords($auto_classifieds->contact_name); ?> </td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <th><a class="call_link"
                            href="tel:<?php echo $auto_classifieds->contact_number; ?>"><?php echo ucwords($auto_classifieds->contact_number); ?></a>
                    </th>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo strtolower($auto_classifieds->contact_email); ?> </td>
                </tr>
                <tr>
                    <th>Display Email?</th>
                    <td><?php if ($auto_classifieds->ShowEmail == 'Yes') {echo "Yes";} else {echo "No";}?> </td>
                </tr>
                <tr>
                    <th>Ad Expiry Date</th>
                    <td><?php echo date("d M, Y", strtotime($auto_classifieds->end_date)); ?> </td>
                </tr>
                </thead>
                </table>
            </div>
            <?php
$pay_data = [
	'user' => ucwords($auto_classifieds->first_name) . '&nbsp;' . ucwords($auto_classifieds->last_name),
	'txt_id' => $auto_classifieds->txn_id,
	'payer_email' => $auto_classifieds->payer_email,
	'amount' => '$' . $auto_classifieds->amount,
	'currency' => $auto_classifieds->currency,
	'payer_status' => $auto_classifieds->payer_status,
	'pay_status' => $auto_classifieds->payment_status,
	'create_at' => $auto_classifieds->created_at,
];
?>
            @if ($auto_classifieds->isPayed == 'Y' && $auto_classifieds->payment_id !== '')
                @include('admin.payment_details',$pay_data)
            @endif
        </div>
    </div>
</div>
</div>

@endsection