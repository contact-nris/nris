@extends('layouts.front',$meta_tags)

@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ url('front/css/nricard.css') }}" />
    @endpush
    <div class="container m-t-124">
        <div class="row">
            @include('front.profile.header')

            <div class="col-12 nricard mt-4">
                <div class="bg-white p-3">

                    {{-- <div class="col-6">
                        <div class="card border-0 shadow-none">
                                    <div class="flip">
                                        <div class="front">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="logo rounded-circle" src="{{ $card->image_url }}"
                                                alt="{{ $card->fname }}" height="50">
                                            <div class="card-holder"> {{ $card->fname . ' ' . $card->lname }} </div>
                                            <div class="card-holder-dob">DOB: {{ date_with_month($card->dob) }} </div>
                                            <div class="card-number">
                                                @foreach (str_split($card->card_no, 4) as $card_no)
                                                    <div class="section">{{ $card_no }}</div>
                                                @endforeach
                                            </div>
                                            <div class="end"><span class="end-text">exp. end:</span><span
                                                    class="end-date">{{ $card->card_type == 1 ? date('m/y', strtotime($card->expiry_date)) : 'Lifetime' }}
                                                </span></div>
                                            <div class="master">
                                                <div class="circle master-red"></div>
                                                <div class="circle master-yellow"></div>
                                            </div>
                                        </div>
                                        <div class="back">
                                            <div class="text-center" style="margin-top: 20%;">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="https://www.nris.com/stuff/images/home_logo_icon.png"
                                                alt="NRIS Card" width="200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                    <table class="table">
                        <thead class="table-secondary text-center text-black">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Card Holder Name </th>
                                <th scope="col">Card No</th>
                                <th scope="col">Date Of Birth</th>
                                <th scope="col">Payment Detail</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Card type</th>
                            </tr>
                        </thead>
                        <tbody class="text-center text-black">
                            @if (count($cards))
                                @foreach ($cards as $card)
                                    <tr>
                                        <td>{{ $card->id }}</td>
                                        <td>{{ $card->fname . ' ' . $card->lname }}</td>
                                        <td>{{ $card->card_no }}</td>
                                        <td>
                                            @if (empty($card->dob))
                                                {{ 'N/A' }}
                                            @else
                                                {{ $card->dob }}
                                            @endif
                                        </td>
                                        <td class="text-left">
                                            <strong> E-mail : </strong>{{ $card->payer_email }} <br>
                                            <strong> amount : </strong>{{ $card->amount }} <br>
                                            <strong> Currency : </strong>{{ $card->currency }} <br>
                                            <strong> Status : </strong>{{ $card->payment_status }} <br>
                                            <strong> Txt_id : </strong>{{ $card->txn_id }}
                                        </td>
                                        <td>{{ $card->card_type == 1 ? date('m/y', strtotime($card->expiry_date)) : 'Lifetime' }}
                                        </td>
                                        <td>{{ $card->card_type == 1 ? 'Yearly' : 'Lifetime' }}</td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center text-black font-weight-bold" colspan="6">You don't have any card yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
