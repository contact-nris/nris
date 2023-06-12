@extends('layouts.front')

@section('content')

    <div class="container">
        <div class="row">
            @include('front.profile.header')

            <div class="col-lg-12 col-md-12 page-content mt-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table-bordered table-hover table text-black">
                            <thead class="thead-light">
                                <tr>
                                    <th>Commnet</th>
                                    <th>Your Bid Price</th>
                                    <th>Ads Bid</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($search_data))
                                    @foreach ($search_data as $val)
                                        <tr>
                                            <td>{{ $val['comment'] }}</td>
                                            <td>{{ $val['amount'] }}</td>
                                            <td>{{ $val['type'] }}</td>
                                            <td>
                                                <a href="{{ route($val['delete_route'], base64_encode($val['id'])) }}"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">
                                            <h3>You don't have any bid yet.</h3>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="text-muted m-0"><strong>Total <span>{{ $search_data->total() }}</span> entries</strong></p>
                        {{ $search_data->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
